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
use Illuminate\Support\Facades\DB;

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
            ->withCount([
                'invoices as unpaid_invoices_count' => function ($q) {
                    $q->unpaid();
                }
            ])
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
                'status'           => 'PENDING',
                'contract_file_url' => $path,
            ]);
            // อัปเดตสถานะห้องเป็น AVAILABLE
            $room->update(['status' => 'AVAILABLE']);

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

    // use Illuminate\Support\Facades\DB;
    // use RealRashid\SweetAlert\Facades\Alert;

    public function remove($id)
    {
        try {
            $lease = \App\Models\LeaseModel::with('room', 'invoices')->find($id);
            if (!$lease) {
                Alert::error('ไม่พบสัญญาเช่า');
                return redirect('/lease');
            }

            if ($lease->hasUnpaidInvoices()) {
                Alert::error('ลบไม่ได้', 'มีใบแจ้งหนี้ที่ยังไม่ชำระ');
                return redirect('/lease');
            }

            DB::transaction(function () use ($lease) {
                // ปลดสถานะห้องให้ว่าง
                if ($lease->room) {
                    $lease->room->update(['status' => 'AVAILABLE']);
                }
                // Soft delete (จะอัปเดต deleted_at)
                $lease->delete();
            });

            Alert::success('ลบสัญญาสำเร็จ');
        } catch (\Throwable $e) {
            Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถลบสัญญาได้');
        }

        return redirect('/lease');
    }


    public function search(Request $request)
    {
        try {
            Paginator::useBootstrap();

            // รับค่าจากฟอร์ม
            $keyword = trim((string) $request->input('keyword', ''));
            $by      = $request->input('by', 'all');

            // กันค่าที่ไม่อนุญาต
            $allowed = ['all', 'user', 'room', 'status', 'rent', 'deposit', 'id'];
            if (!in_array($by, $allowed, true)) {
                $by = 'all';
            }

            // base query + join ความสัมพันธ์ที่จำเป็น
            $q = LeaseModel::with(['user', 'room'])
                ->withCount([
                    'invoices as unpaid_invoices_count' => function ($q2) {
                        $q2->unpaid();
                    }
                ]);

            // ถ้ามี keyword ค่อยประกอบเงื่อนไข
            if ($keyword !== '') {
                switch ($by) {
                    case 'user':
                        // ค้นจากชื่อผู้เช่า (users.full_name)
                        $q->whereHas('user', function ($w) use ($keyword) {
                            $w->where('full_name', 'LIKE', '%' . $keyword . '%');
                        });
                        break;

                    case 'room':
                        // ค้นจากเลขห้อง (rooms.room_no)
                        $q->whereHas('room', function ($w) use ($keyword) {
                            $w->where('room_no', 'LIKE', '%' . $keyword . '%');
                        });
                        break;

                    case 'status':
                        // ค้นสถานะแบบยืดหยุ่น (ตัวพิมพ์เล็ก/ใหญ่/บางส่วน)
                        $q->where(function ($w) use ($keyword) {
                            $w->where('status', 'LIKE', '%' . strtoupper($keyword) . '%')
                                ->orWhere('status', 'LIKE', '%' . ucfirst(strtolower($keyword)) . '%')
                                ->orWhere('status', 'LIKE', '%' . strtolower($keyword) . '%');
                        });
                        break;

                    case 'rent':
                        // ค้นค่าเช่า: ถ้าเป็นตัวเลขให้เทียบตรง ๆ, ถ้าไม่ใช่ใช้ LIKE
                        $num = str_replace([','], '', $keyword);
                        if (is_numeric($num)) {
                            $q->where('rent_amount', (float) $num);
                        } else {
                            $q->where('rent_amount', 'LIKE', '%' . $keyword . '%');
                        }
                        break;

                    case 'deposit':
                        $num = str_replace([','], '', $keyword);
                        if (is_numeric($num)) {
                            $q->where('deposit_amount', (float) $num);
                        } else {
                            $q->where('deposit_amount', 'LIKE', '%' . $keyword . '%');
                        }
                        break;

                    case 'id':
                        // ค้นด้วยเลขสัญญาเช่า
                        if (ctype_digit($keyword)) {
                            $q->where('id', (int)$keyword);
                        } else {
                            $q->whereRaw('1=0'); // ไม่ใช่ตัวเลข → บังคับไม่พบผลลัพธ์
                        }
                        break;

                    case 'all':
                    default:
                        // ค้นทุกช่องหลัก ๆ (รวม user, room)
                        $q->where(function ($w) use ($keyword) {
                            $w->where('status', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('rent_amount', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('deposit_amount', 'LIKE', '%' . $keyword . '%');

                            // join ความสัมพันธ์เพื่อ orWhere ข้ามตาราง
                            $w->orWhereHas('user', function ($wu) use ($keyword) {
                                $wu->where('full_name', 'LIKE', '%' . $keyword . '%');
                            });
                            $w->orWhereHas('room', function ($wr) use ($keyword) {
                                $wr->where('room_no', 'LIKE', '%' . $keyword . '%');
                            });

                            // ถ้าเป็นตัวเลขให้ลองแมตช์กับ id โดยตรงด้วย
                            if (ctype_digit($keyword)) {
                                $w->orWhere('id', (int)$keyword);
                            }
                        });
                        break;
                }
            }

            // เรียง & เพจจิเนชัน + เก็บ query string เดิมไว้ในลิงก์ถัดไป
            $LeasesList = $q->orderBy('id', 'desc')
                ->paginate(10)
                ->appends($request->query());

            return view('lease.list', compact('LeasesList'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
            // หรือ: return view('errors.404');
        }
    }
}
