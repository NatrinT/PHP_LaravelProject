<?php

namespace App\Http\Controllers;

use App\Models\LeaseModel;
use App\Models\RoomModel;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LeaseController extends Controller
{
    // กำหนดสถานะที่อนุญาตให้ชัดเจน
    private const STATUSES = ['PENDING', 'ACTIVE', 'ENDED', 'CANCELED'];

    public function __construct()
    {
        // ใช middleware 'auth:admin' เพื่อบังคับใหตองล็อกอินในฐานะ admin กอนใชงาน
        // controller นี้
        // ถาไมล็อกอินหรือไมไดใช guard 'admin' จะถูก redirect ไปหนา login
        $this->middleware('auth:admin');
    }

    public function index()
    {
        Paginator::useBootstrap();
        $LeasesList = LeaseModel::with(['user', 'room'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('lease.list', compact('LeasesList'));
    }

    public function adding()
    {
        $users = UsersModel::orderBy('full_name')->get();
        $rooms = RoomModel::where('status', 'AVAILABLE')->orderBy('room_no')->get(); // เอาเฉพาะห้องว่าง
        return view('lease.create', compact('users', 'rooms'));
    }


    public function create(Request $request)
    {
        $messages = [
            'user_id.required'   => 'กรุณาเลือกผู้เช่า',
            'user_id.exists'     => 'ไม่พบผู้เช่า',
            'room_id.required'   => 'กรุณาเลือกห้อง',
            'room_id.exists'     => 'ไม่พบห้อง',
            'start_date.required' => 'กรุณากำหนดวันเริ่มสัญญา',
            'end_date.required'  => 'กรุณากำหนดวันสิ้นสุดสัญญา',
            'end_date.after_or_equal' => 'วันสิ้นสุดต้องไม่น้อยกว่าวันเริ่ม',
            'rent_amount.required' => 'กรุณากำหนดค่าเช่า',
            'rent_amount.numeric' => 'ค่าเช่าต้องเป็นตัวเลข',
            'rent_amount.min'     => 'ค่าเช่าต้องไม่น้อยกว่า 500 บาท',
            'deposit_amount.numeric' => 'เงินมัดจำต้องเป็นตัวเลข',
            'deposit_amount.min'    => 'เงินมัดจำต้องไม่น้อยกว่า 0',
            'status.in'           => 'สถานะไม่ถูกต้อง',
            'contract_file.mimes' => 'อัปโหลดได้เฉพาะ pdf, jpg, jpeg, png',
            'contract_file.max'   => 'ไฟล์ต้องไม่เกิน 5MB',
        ];

        $validator = Validator::make($request->all(), [
            'user_id'        => 'required|exists:users,id',
            'room_id'        => 'required|exists:rooms,id',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'rent_amount'    => 'required|numeric|min:500',
            'deposit_amount' => 'nullable|numeric|min:0',
            'contract_file'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], $messages);

        if ($validator->fails()) {
            return redirect('lease/adding')
                ->withErrors($validator)
                ->withInput();
        }

        $room = RoomModel::find($request->room_id);
        if (!$room || $room->status !== 'AVAILABLE') {
            return redirect('lease/adding')
                ->withErrors(['room_id' => 'ห้องนี้ไม่ว่าง ไม่สามารถจองได้'])
                ->withInput();
        }

        try {
            $path = null;
            if ($request->hasFile('contract_file')) {
                $path = $request->file('contract_file')->store('uploads/contracts', 'public');
            }

            LeaseModel::create([
                'user_id'          => $request->user_id,
                'room_id'          => $request->room_id,
                'start_date'       => $request->start_date,
                'end_date'         => $request->end_date,
                'rent_amount'      => $request->rent_amount,
                'deposit_amount'   => $request->deposit_amount,
                'status'           => 'ACTIVE',
                'contract_file_url' => $path,
            ]);
            // อัปเดตสถานะห้องเป็น OCCUPIED
            $room->update(['status' => 'OCCUPIED']);

            Alert::success('เพิ่มสัญญาเช่าสำเร็จ');
            return redirect('/lease');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $lease = LeaseModel::with(['user', 'room'])->findOrFail($id);
            $users = UsersModel::orderBy('full_name')->get(['id', 'full_name']);
            $rooms = RoomModel::orderBy('room_no')->get(['id', 'room_no']);

            // แตกตัวแปรส่งไป view
            $data = [
                'id'             => $lease->id,
                'user_id'        => $lease->user_id,
                'room_id'        => $lease->room_id,
                'start_date'     => $lease->start_date?->format('Y-m-d'),
                'end_date'       => $lease->end_date?->format('Y-m-d'),
                'rent_amount'    => $lease->rent_amount,
                'deposit_amount' => $lease->deposit_amount,
                'status'         => $lease->status,
                'contract_file_url' => $lease->contract_file_url,
            ];

            return view('lease.edit', $data + compact('users', 'rooms'));
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function update($id, Request $request)
    {
        $messages = [
            'user_id.required'   => 'กรุณาเลือกผู้เช่า',
            'user_id.exists'     => 'ไม่พบผู้เช่า',
            'room_id.required'   => 'กรุณาเลือกห้อง',
            'room_id.exists'     => 'ไม่พบห้อง',
            'start_date.required' => 'กรุณากำหนดวันเริ่มสัญญา',
            'end_date.required'  => 'กรุณากำหนดวันสิ้นสุดสัญญา',
            'end_date.after_or_equal' => 'วันสิ้นสุดต้องไม่น้อยกว่าวันเริ่ม',
            'rent_amount.required' => 'กรุณากำหนดค่าเช่า',
            'rent_amount.numeric' => 'ค่าเช่าต้องเป็นตัวเลข',
            'rent_amount.min'     => 'ค่าเช่าต้องไม่น้อยกว่า 500 บาท',
            'deposit_amount.numeric' => 'เงินมัดจำต้องเป็นตัวเลข',
            'deposit_amount.min'    => 'เงินมัดจำต้องไม่น้อยกว่า 0',
            'status.in'           => 'สถานะไม่ถูกต้อง',
            'contract_file.mimes' => 'อัปโหลดได้เฉพาะ pdf, jpg, jpeg, png',
            'contract_file.max'   => 'ไฟล์ต้องไม่เกิน 5MB',
        ];

        $validator = Validator::make($request->all(), [
            'user_id'        => 'required|exists:users,id',
            'room_id'        => 'required|exists:rooms,id',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'rent_amount'    => 'required|numeric|min:500',
            'deposit_amount' => 'nullable|numeric|min:0',
            'status'         => 'required|in:' . implode(',', self::STATUSES),
            'contract_file'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], $messages);

        if ($validator->fails()) {
            return redirect('lease/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $lease = LeaseModel::findOrFail($id);

            // อัปโหลดไฟล์ใหม่ (ถ้ามี) และลบไฟล์เก่า
            $path = $lease->contract_file_url;
            if ($request->hasFile('contract_file')) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $path = $request->file('contract_file')->store('uploads/contracts', 'public');
            }

            $lease->update([
                'user_id'          => (int) $request->user_id,
                'room_id'          => (int) $request->room_id,
                'start_date'       => $request->start_date,
                'end_date'         => $request->end_date,
                'rent_amount'      => $request->rent_amount,
                'deposit_amount'   => $request->deposit_amount,
                'status'           => $request->status,
                'contract_file_url' => $path,
            ]);

            if ($lease->status === 'ENDED' || $lease->status === 'CANCELED') {
                $lease->room->update(['status' => 'AVAILABLE']);
            } elseif ($lease->status === 'ACTIVE') {
                $lease->room->update(['status' => 'OCCUPIED']);
            } else {
                // กรณี PENDING หรือสถานะอื่นๆ
                $lease->room->update(['status' => 'AVAILABLE']);
            }


            Alert::success('ปรับปรุงสัญญาสำเร็จ');
            return redirect('/lease');
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function remove($id)
    {
        try {
            $lease = LeaseModel::find($id);
            if (!$lease) {
                Alert::error('ไม่พบสัญญาเช่า');
                return redirect('/lease');
            }

            // ลบไฟล์สัญญาถ้ามี
            if ($lease->contract_file_url && Storage::disk('public')->exists($lease->contract_file_url)) {
                Storage::disk('public')->delete($lease->contract_file_url);
            }

            // คืนห้องว่าง ไม่ว่าลบ Lease ที่สถานะอะไร
            if ($lease->room) {
                $lease->room->update(['status' => 'AVAILABLE']);
            }

            $lease->delete();

            Alert::success('ลบสัญญาสำเร็จ');
            return redirect('/lease');
        } catch (\Exception $e) {
            Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
            return redirect('/lease');
        }
    }
    public function search(Request $request)
    {
        Paginator::useBootstrap();

        $q = LeaseModel::with(['user', 'room']);

        if ($request->filled('q')) {
            $kw = trim($request->q);

            $q->where(function ($w) use ($kw) {
                // 1) user / room (กว้างได้)
                $w->whereHas('user', function ($u) use ($kw) {
                    $u->where('full_name', 'like', "%{$kw}%")
                        ->orWhere('email', 'like', "%{$kw}%")
                        ->orWhere('phone', 'like', "%{$kw}%");
                })->orWhereHas('room', function ($r) use ($kw) {
                    $r->where('room_no', 'like', "%{$kw}%")
                        ->orWhere('type', 'like', "%{$kw}%");
                });

                // 2) status: จับแบบขึ้นต้น/เท่ากับ (ไม่ใช้ %...%)
                $statuses = ['PENDING', 'ACTIVE', 'ENDED', 'CANCELED'];
                $kwUpper  = strtoupper($kw);
                $matchStatuses = array_values(array_filter($statuses, function ($s) use ($kwUpper) {
                    return str_starts_with($s, $kwUpper); // 'ac' -> ACTIVE
                }));

                $w->orWhere(function ($s) use ($matchStatuses, $kwUpper) {
                    if (!empty($matchStatuses)) {
                        $s->whereIn('status', $matchStatuses);
                    } else {
                        // เผื่อเคสอยากค้นคำเต็มๆ ที่เป็นคำอื่น
                        $s->where('status', 'like', "%{$kwUpper}%");
                    }
                });

                // 3) ตัวเลข -> จับ rent/deposit เท่ากัน
                if (is_numeric($kw)) {
                    $w->orWhere('rent_amount', (float)$kw)
                        ->orWhere('deposit_amount', (float)$kw);
                }

                // 4) วันเวลา: พาร์สเฉพาะที่ “ดูเหมือนวันที่”
                if (preg_match('/^\d{4}-\d{2}-\d{2}$|^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}$/', $kw)) {
                    try {
                        $asDate   = \Carbon\Carbon::parse($kw);
                        $dayStart = $asDate->copy()->startOfDay();
                        $dayEnd   = $asDate->copy()->endOfDay();
                        $w->orWhereBetween('start_date', [$dayStart, $dayEnd])
                            ->orWhereBetween('end_date',   [$dayStart, $dayEnd]);
                    } catch (\Exception $e) {
                        // ไม่ใช่วันที่จริง ก็ไม่เพิ่มเงื่อนไขวัน
                    }
                }

                // 5) ไฟล์สัญญา (ได้อยู่ที่ like กว้าง)
                $w->orWhere('contract_file_url', 'like', "%{$kw}%");
            });
        }

        // ฟิลเตอร์อื่นๆ ที่มีในหน้า
        if ($request->filled('status')) {
            $status = strtoupper($request->status);
            if (in_array($status, self::STATUSES, true)) {
                $q->where('status', $status);
            }
        }
        if ($request->filled('start_from')) $q->whereDate('start_date', '>=', $request->start_from);
        if ($request->filled('start_to'))   $q->whereDate('start_date', '<=', $request->start_to);
        if ($request->filled('end_from'))   $q->whereDate('end_date', '>=', $request->end_from);
        if ($request->filled('end_to'))     $q->whereDate('end_date',   '<=', $request->end_to);
        if ($request->filled('rent_min'))   $q->where('rent_amount', '>=', (float)$request->rent_min);
        if ($request->filled('rent_max'))   $q->where('rent_amount', '<=', (float)$request->rent_max);

        // ให้ลำดับเหมือน index เสมอ
        $q->orderBy('id', 'desc');

        $LeasesList = $q->paginate(10)->withQueryString();

        return view('lease.list', compact('LeasesList'));
    }
}
