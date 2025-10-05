<?php

namespace App\Http\Controllers;

use App\Models\RoomModel;
use App\Models\LeaseModel;
use App\Models\InvoiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    public function showCheckout(RoomModel $room, Request $req)
    {
        return view('content.bookingContent', [
            'room'       => $room,
            'start_date' => $req->query('start_date'),
            'end_date'   => $req->query('end_date'),
        ]);
    }

    public function processCheckout(Request $req)
    {
        // ต้องล็อกอินก่อนทำรายการ
        $userId = Auth::id() ?? session('user_id');
        if (!$userId) {
            Alert::error('เข้าสู่ระบบก่อนจอง', 'กรุณาเข้าสู่ระบบก่อนทำการจอง');
            return redirect()->route('login');
        }

        // ตรวจสอบข้อมูลฟอร์ม
        $validated = $req->validate([
            'room_id'        => ['required', 'exists:rooms,id'],
            'first_name'     => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email'],
            'phone'          => ['required', 'string', 'max:30'],
            'start_date'     => ['required', 'date', 'after_or_equal:today'],
            'months'         => ['required', 'integer', 'min:1'],
            'end_date'       => ['nullable', 'date', 'after_or_equal:start_date'], // ให้ server ช่วยคำนวณได้
            'payment_method' => ['required', 'in:card,qr,mobile,wallet,cash'],
            'payment_slip'   => ['required_if:payment_method,qr', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        // เตรียมข้อมูลวันที่
        $room   = RoomModel::findOrFail($validated['room_id']);
        $rent   = (float) $room->monthly_rent;
        $start  = Carbon::parse($validated['start_date'])->startOfDay();
        $months = (int) $validated['months'];
        $end    = $req->filled('end_date')
            ? Carbon::parse($validated['end_date'])->endOfDay()
            : $start->copy()->addMonths($months)->subDay()->endOfDay(); // (start + months) - 1 วัน

        // กันทับซ้อนสัญญาเช่าเดิม
        $overlap = LeaseModel::where('room_id', $room->id)
            ->whereNull('deleted_at')
            ->whereIn('status', ['ACTIVE', 'PENDING'])
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start->toDateString(), $end->toDateString()])
                    ->orWhereBetween('end_date',   [$start->toDateString(), $end->toDateString()])
                    ->orWhere(function ($z) use ($start, $end) {
                        $z->where('start_date', '<=', $start->toDateString())
                            ->where('end_date',   '>=', $end->toDateString());
                    });
            })
            ->exists();

        if ($overlap) {
            Alert::error('ไม่สามารถจองช่วงนี้ได้', 'ช่วงวันที่ที่เลือกมีสัญญาเดิมทับซ้อนอยู่แล้ว');
            return back()->withInput();
        }

        // ค่าธรรมเนียม/ยอดรวม (ตาม UI)
        $deposit      = round($rent * 1, 2);
        $cleaning     = 500.00;
        $service      = 99.00;
        $discount     = 0.00;
        $rentSubtotal = $rent * $months;
        $invoiceTotal = max(0, $rentSubtotal + $deposit + $cleaning + $service - $discount);

        // อัปโหลดสลิป (จำเป็นเมื่อเลือก QR)
        $receiptPath = null; // เก็บเป็น relative path บน disk 'public'
        if ($req->hasFile('payment_slip')) {
            $receiptPath = $req->file('payment_slip')->store('uploads/receipts', 'public');
        }

        DB::beginTransaction();
        try {
            // 1) สร้าง Lease เริ่มต้นสถานะ PENDING
            $lease = LeaseModel::create([
                'user_id'           => $userId,
                'room_id'           => $room->id,
                'start_date'        => $start->toDateString(),
                'end_date'          => $end->toDateString(),
                'rent_amount'       => $rent,
                'deposit_amount'    => $deposit,
                'status'            => 'PENDING',
                'contract_file_url' => null,
            ]);

            // 2) สร้าง Invoice แรก
            InvoiceModel::create([
                'lease_id'         => $lease->id,
                'billing_period'   => $start->format('Y-m'),
                'due_date'         => $start->toDateString(),
                'amount_rent'      => $rentSubtotal,
                'amount_utilities' => 0,
                'amount_other'     => ($deposit + $cleaning + $service - $discount),
                'total_amount'     => $invoiceTotal,
                'status'           => 'ISSUED',
                'payment_status'   => in_array($validated['payment_method'], ['card', 'cash']) ? 'CONFIRMED' : 'PENDING',
                'receipt_file_url' => $receiptPath,
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($receiptPath) {
                Storage::disk('public')->delete($receiptPath);
            }
            Alert::error('บันทึกไม่สำเร็จ', $e->getMessage());
            return back()->withInput();
        }

        Alert::success('ทำรายการจองสำเร็จแล้ว!', 'เรากำลังตรวจสอบการชำระเงินของคุณ');
        return redirect()->route('checkout.myBooking');
    }
}
