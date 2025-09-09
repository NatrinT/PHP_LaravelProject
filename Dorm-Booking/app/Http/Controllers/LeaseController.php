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

class LeaseController extends Controller
{
    // กำหนดสถานะที่อนุญาตให้ชัดเจน
    private const STATUSES = ['PENDING','ACTIVE','ENDED','CANCELED'];

    public function index()
    {
        Paginator::useBootstrap();
        $LeasesList = LeaseModel::with(['user','room'])
            ->orderBy('id','desc')
            ->paginate(10);

        return view('lease.list', compact('LeasesList'));
    }

    public function adding()
    {
        // ถ้าจะทำ dropdown เลือกผู้ใช้/ห้อง
        $users = UsersModel::orderBy('full_name')->get(['id','full_name']);
        $rooms = RoomModel::orderBy('room_no')->get(['id','room_no']);
        return view('lease.create', compact('users','rooms'));
    }

    public function create(Request $request)
    {
        $messages = [
            'user_id.required'   => 'กรุณาเลือกผู้เช่า',
            'user_id.exists'     => 'ไม่พบผู้เช่า',
            'room_id.required'   => 'กรุณาเลือกห้อง',
            'room_id.exists'     => 'ไม่พบห้อง',
            'start_date.required'=> 'กรุณากำหนดวันเริ่มสัญญา',
            'end_date.required'  => 'กรุณากำหนดวันสิ้นสุดสัญญา',
            'end_date.after_or_equal' => 'วันสิ้นสุดต้องไม่น้อยกว่าวันเริ่ม',
            'rent_amount.required'=> 'กรุณากำหนดค่าเช่า',
            'rent_amount.numeric' => 'ค่าเช่าต้องเป็นตัวเลข',
            'rent_amount.min'     => 'ค่าเช่าต้องไม่น้อยกว่า 500 บาท',
            'deposit_amount.numeric'=> 'เงินมัดจำต้องเป็นตัวเลข',
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
            'status'         => 'nullable|in:'.implode(',', self::STATUSES),
            'contract_file'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], $messages);

        if ($validator->fails()) {
            return redirect('lease/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $path = null;
            if ($request->hasFile('contract_file')) {
                $path = $request->file('contract_file')->store('uploads/contracts', 'public');
            }

            LeaseModel::create([
                'user_id'          => (int) $request->user_id,
                'room_id'          => (int) $request->room_id,
                'start_date'       => $request->start_date,
                'end_date'         => $request->end_date,
                'rent_amount'      => $request->rent_amount,
                'deposit_amount'   => $request->deposit_amount,
                'status'           => $request->status ?: 'PENDING',
                'contract_file_url'=> $path,
            ]);

            Alert::success('เพิ่มสัญญาเช่าสำเร็จ');
            return redirect('/lease');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $lease = LeaseModel::with(['user','room'])->findOrFail($id);
            $users = UsersModel::orderBy('full_name')->get(['id','full_name']);
            $rooms = RoomModel::orderBy('room_no')->get(['id','room_no']);

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

            return view('lease.edit', $data + compact('users','rooms'));
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
            'start_date.required'=> 'กรุณากำหนดวันเริ่มสัญญา',
            'end_date.required'  => 'กรุณากำหนดวันสิ้นสุดสัญญา',
            'end_date.after_or_equal' => 'วันสิ้นสุดต้องไม่น้อยกว่าวันเริ่ม',
            'rent_amount.required'=> 'กรุณากำหนดค่าเช่า',
            'rent_amount.numeric' => 'ค่าเช่าต้องเป็นตัวเลข',
            'rent_amount.min'     => 'ค่าเช่าต้องไม่น้อยกว่า 500 บาท',
            'deposit_amount.numeric'=> 'เงินมัดจำต้องเป็นตัวเลข',
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
            'status'         => 'required|in:'.implode(',', self::STATUSES),
            'contract_file'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], $messages);

        if ($validator->fails()) {
            return redirect('lease/'.$id)
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
                'contract_file_url'=> $path,
            ]);

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

            $lease->delete();
            Alert::success('ลบสัญญาสำเร็จ');
            return redirect('/lease');
        } catch (\Exception $e) {
            Alert::error('เกิดข้อผิดพลาด: '.$e->getMessage());
            return redirect('/lease');
        }
    }
}
