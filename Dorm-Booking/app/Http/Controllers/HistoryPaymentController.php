<?php

namespace App\Http\Controllers;

use App\Models\InvoiceModel;
use App\Models\LeaseModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class HistoryPaymentController extends Controller
{
    /**
     * แสดงประวัติการชำระเงิน (Invoices) ของผู้ใช้ที่ล็อกอิน
     * รองรับค้นคำ (q), สถานะ (status), และเลือกงวดเดือน (period = YYYY-MM)
     */
    public function index(Request $request)
    {
        Paginator::useBootstrap();

        // ต้องล็อกอิน
        $userId = Auth::id() ?? session('user_id');
        if (!$userId) {
            Alert::error('กรุณาเข้าสู่ระบบก่อน', 'ต้องล็อกอินก่อนเข้าหน้านี้');
            return redirect()->route('login');
        }

        // ===== ฟิลเตอร์จาก query string =====
        $q       = trim((string) $request->query('q', ''));
        $status  = strtoupper(trim((string) $request->query('status', ''))); // PAID/ISSUED/OVERDUE/PENDING/CONFIRMED
        $period  = trim((string) $request->query('period', ''));             // YYYY-MM

        // หาเดือนเริ่ม/สิ้นสุดสำหรับ period (ถ้ามี)
        $periodStart = null;
        $periodEnd   = null;
        if (preg_match('/^\d{4}-\d{2}$/', $period)) {
            $periodStart = Carbon::createFromFormat('Y-m', $period)->startOfMonth()->toDateString();
            $periodEnd   = Carbon::createFromFormat('Y-m', $period)->endOfMonth()->toDateString();
        }

        // ===== Base query: invoice ของผู้ใช้ (ผ่าน lease->user_id) + ความสัมพันธ์ที่ต้องใช้บนตาราง =====
        $base = InvoiceModel::with([
            'lease' => function ($q) {
                $q->select('id', 'user_id', 'room_id', 'start_date', 'end_date', 'status');
            },
            'lease.room' => function ($q) {
                $q->select('id', 'room_no', 'branch', 'type', 'monthly_rent');
            },
        ])
            ->whereHas('lease', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });

        // ===== ฟิลเตอร์คำค้น: ห้อง/ประเภท/บันทึก/สาขา (ค้นใน room) =====
        if ($q !== '') {
            $base->whereHas('lease.room', function ($wr) use ($q) {
                $wr->where('room_no', 'LIKE', "%{$q}%")
                    ->orWhere('type', 'LIKE', "%{$q}%")
                    ->orWhere('branch', 'LIKE', "%{$q}%");
            });
        }

        // ===== ฟิลเตอร์สถานะชำระเงิน =====
        if ($status !== '') {
            switch ($status) {
                case 'PAID':
                    // จ่ายแล้ว: สถานะ invoice เป็น PAID หรือ payment_status ถูกคอนเฟิร์ม
                    $base->where(function ($w) {
                        $w->where('status', 'PAID')
                            ->orWhere('payment_status', 'CONFIRMED');
                    });
                    break;

                case 'CONFIRMED':
                    $base->where('payment_status', 'CONFIRMED');
                    break;

                case 'ISSUED':
                    $base->where('status', 'ISSUED');
                    break;

                case 'OVERDUE':
                    $base->where('status', 'OVERDUE');
                    break;

                case 'PENDING':
                    // รอตรวจ/ยังไม่คอนเฟิร์ม
                    $base->where(function ($w) {
                        $w->whereNull('payment_status')
                            ->orWhere('payment_status', 'PENDING');
                    });
                    break;

                default:
                    // ไม่ตรงลิสต์ → ไม่ฟิลเตอร์
                    break;
            }
        }

        // ===== ฟิลเตอร์เดือน (period) จาก billing_period หรือ due_date =====
        if ($periodStart && $periodEnd) {
            $base->where(function ($w) use ($period, $periodStart, $periodEnd) {
                $w->where('billing_period', $period)
                    ->orWhereBetween('due_date', [$periodStart, $periodEnd]);
            });
        }

        // เรียง & เพจ
        $invoices = $base->orderByDesc('id')
            ->paginate(10)
            ->appends($request->query());

        // ===== ชิปสรุปสถานะบนหัวตาราง (นับจาก invoice ทั้งหมดของผู้ใช้) =====
        $all = InvoiceModel::whereHas('lease', fn($q) => $q->where('user_id', $userId))
            ->get(['status', 'payment_status']);

        $counts = [
            'paid'      => $all->filter(fn($i) => strtoupper($i->status) === 'PAID' || strtoupper($i->payment_status) === 'CONFIRMED')->count(),
            'issued'    => $all->where('status', 'ISSUED')->count(),
            'overdue'   => $all->where('status', 'OVERDUE')->count(),
            'pending'   => $all->filter(fn($i) => is_null($i->payment_status) || strtoupper($i->payment_status) === 'PENDING')->count(),
        ];

        return view('content.historyPayment', compact('invoices', 'counts', 'period'));
    }

    /**
     * อัปโหลด/อัปเดตสลิป (receipt_file_url) ให้ Invoice ที่เลือก
     */
    public function uploadReceipt(InvoiceModel $invoice, Request $request)
    {
        $userId = Auth::id() ?? session('user_id');
        if (!$userId) {
            Alert::error('กรุณาเข้าสู่ระบบก่อน');
            return redirect()->route('login');
        }

        // ต้องเป็นเจ้าของสัญญาเช่าที่ invoice นี้สังกัดอยู่
        if (!$invoice->lease || (int) $invoice->lease->user_id !== (int) $userId) {
            Alert::error('ไม่อนุญาต', 'คุณไม่มีสิทธิ์แก้ไขใบแจ้งหนี้นี้');
            return back();
        }

        $request->validate([
            'receipt_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'receipt_file.required' => 'กรุณาเลือกไฟล์หลักฐานการชำระ',
            'receipt_file.mimes'    => 'รองรับเฉพาะ pdf, jpg, jpeg, png',
            'receipt_file.max'      => 'ไฟล์ต้องไม่เกิน 5MB',
        ]);

        // ลบไฟล์เก่าถ้ามี แล้วอัปใหม่
        $old = $invoice->receipt_file_url;
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        $path = $request->file('receipt_file')->store('uploads/receipts', 'public');

        $invoice->update([
            'receipt_file_url' => $path,
            // ถ้ายังไม่มีสถานะการชำระ ให้ตั้งเป็น PENDING (รอตรวจ)
            'payment_status'   => $invoice->payment_status ?: 'PENDING',
        ]);

        Alert::success('อัปโหลดสลิปแล้ว', 'เราจะตรวจสอบการชำระเงินของคุณโดยเร็ว');
        return back();
    }
}
