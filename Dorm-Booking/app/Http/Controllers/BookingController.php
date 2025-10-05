<?php

namespace App\Http\Controllers;

use App\Models\LeaseModel;
use App\Models\InvoiceModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * หน้า “การจองของฉัน”
     */
    public function index(Request $request)
    {
        Paginator::useBootstrap();

        // รองรับทั้ง auth() และ session('user_id')
        $userId = Auth::id() ?? session('user_id');
        if (!$userId) {
            Alert::error('กรุณาเข้าสู่ระบบก่อน', 'ต้องล็อกอินก่อนเข้าหน้านี้');
            return redirect()->route('login');
        }

        // ฟิลเตอร์จาก query string
        $q      = trim((string) $request->query('q', ''));
        $branch = trim((string) $request->query('branch', ''));
        $status = trim((string) $request->query('status', ''));

        // ดึงสาขาทั้งหมดจาก rooms (เฉพาะที่มีจริงใน DB)
        $branches = RoomModel::query()
            ->whereNotNull('branch')
            ->where('branch', '!=', '')
            ->distinct()
            ->orderBy('branch')
            ->pluck('branch')
            ->toArray();

        // base: lease ของ user ปัจจุบัน + เอาข้อมูลห้องจาก id (ผ่านความสัมพันธ์ room) + ใบแจ้งหนี้ล่าสุด
        $base = LeaseModel::with([
            'room',                      // ดึงห้องจาก room_id
            'invoices' => fn($q) => $q->orderByDesc('id'),
        ])->where('user_id', $userId);

        // ฟิลเตอร์คำค้น (ค้นในข้อมูลห้อง)
        if ($q !== '') {
            $base->where(function ($w) use ($q) {
                $w->whereHas('room', function ($wr) use ($q) {
                    $wr->where('room_no', 'LIKE', "%{$q}%")
                        ->orWhere('type', 'LIKE', "%{$q}%")
                        ->orWhere('note', 'LIKE', "%{$q}%");
                });
            });
        }

        // ฟิลเตอร์สาขา (ที่เลือกจาก dropdown ซึ่งมาจาก rooms จริง ๆ)
        if ($branch !== '') {
            $base->whereHas('room', function ($wr) use ($branch) {
                $wr->where('branch', $branch);
            });
        }

        // ฟิลเตอร์สถานะ: รองรับ UPCOMING (ตีความเป็น PENDING หรือ start_date > today)
        $today = Carbon::today()->toDateString();
        if ($status !== '') {
            if ($status === 'UPCOMING') {
                // ให้ UPCOMING = PENDING เท่านั้น เพื่อให้ตรงกับชิป
                $base->where('status', 'PENDING');
            } else {
                $base->where('status', strtoupper($status));
            }
        }

        // เพจจิเนชัน
        $bookings = $base->orderByDesc('id')
            ->paginate(10)
            ->appends($request->query());

        // นับสถานะสำหรับชิปด้านบน (ดึงจาก DB ทั้งหมดของ user)
        $allOfUser = LeaseModel::where('user_id', $userId)->get(['status', 'start_date']);
        $counts = [
            'active'   => $allOfUser->where('status', 'ACTIVE')->count(),
            'upcoming' => $allOfUser->filter(function ($l) use ($today) {
                return ($l->status === 'PENDING');
            })->count(),
            'ended'    => $allOfUser->where('status', 'ENDED')->count(),
            'canceled' => $allOfUser->where('status', 'CANCELED')->count(),
        ];

        return view('content.myBookingContent', compact('bookings', 'branches', 'counts'));
    }

    /**
     * อัปโหลด/อัปเดตสลิปให้ใบแจ้งหนี้ (receipt_file_url)
     */
    public function uploadReceipt(InvoiceModel $invoice, Request $request)
    {
        $userId = Auth::id() ?? session('user_id');
        if (!$userId) {
            Alert::error('กรุณาเข้าสู่ระบบก่อน');
            return redirect()->route('login');
        }

        // ต้องเป็นเจ้าของ lease นี้เท่านั้น
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

        // ลบไฟล์เก่าแล้วอัปใหม่
        $old = $invoice->receipt_file_url;
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        $path = $request->file('receipt_file')->store('uploads/receipts', 'public');

        $invoice->update([
            'receipt_file_url' => $path,
            'payment_status'   => $invoice->payment_status ?: 'PENDING',
        ]);

        Alert::success('อัปโหลดสลิปแล้ว', 'เราจะตรวจสอบการชำระเงินของคุณโดยเร็ว');
        return back();
    }
}
