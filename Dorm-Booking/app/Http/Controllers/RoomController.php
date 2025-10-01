<?php

namespace App\Http\Controllers;

use App\Models\RoomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{

    public function __construct()
    {
        // ใช middleware 'auth:admin' เพื่อบังคับใหตองล็อกอินในฐานะ admin กอนใชงาน
        // controller นี้
        // ถาไมล็อกอินหรือไมไดใช guard 'admin' จะถูก redirect ไปหนา login
        $this->middleware('auth:admin');
    }

    public function index()
    {
        try {
            Paginator::useBootstrap();
            $RoomList = RoomModel::orderBy('floor')->paginate(5); //order by & pagination
            return view('rooms.list', compact('RoomList'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    }

    public function adding()
    {
        return view('rooms.create');
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'room_no.required' => 'กรุณากรอกข้อมูล',
            'room_no.unique' => 'เลขห้องซ้ำ เพิ่มใหม่อีกครั้ง',

            'floor.required' => 'กรุณากรอกข้อมูล',
            'floor.min' => 'ชั้นต้องไม่เป็น 0 หรือต่ำกว่า :min',

            'type.required' => 'กรุณากรอกข้อมูล',

            'status.required' => 'กรุณากรอกข้อมูล',

            'monthly_rent.required' => 'กรุณากรอกข้อมูล',
            'monthly_rent.min' => 'ค่าเช่าต้องไม่ต่ำกว่า 500 บาท',
        ];


        //rule 
        $validator = Validator::make($request->all(), [
            'room_no' => 'required|unique:rooms',
            'floor' => 'required|integer|min:1',
            'type' => 'required',
            'status' => 'required',
            'monthly_rent' => 'required|numeric|min:500',
        ], $messages);


        //check vali 
        if ($validator->fails()) {
            return redirect('room/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            RoomModel::create([
                'room_no' => strip_tags($request->input('room_no')),
                'floor' => strip_tags($request->input('floor')),
                'type' => strip_tags($request->input('type')),
                'status' => strip_tags($request->input('status')),
                'monthly_rent' => strip_tags($request->input('monthly_rent')),
                'note' => strip_tags($request->input('note')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/room');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun create



    public function edit($id)
    {
        try {
            //query data for form edit 
            $room = RoomModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($room)) {
                $id = $room->id;
                $room_no = $room->room_no;
                $floor = $room->floor;
                $type = $room->type;
                $status = $room->status;
                $monthly_rent = $room->monthly_rent;
                $note = $room->note;
                return view('rooms.edit', compact('id', 'room_no', 'floor', 'type', 'status', 'monthly_rent', 'note'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit


    public function update($id, Request $request)
    {
        //vali msg 
        $messages = [
            // 'room_no.required' => 'กรุณากรอกข้อมูล',
            // 'room_no.unique' => 'เลขห้องซ้ำ เพิ่มใหม่อีกครั้ง',

            'floor.required' => 'กรุณากรอกข้อมูล',
            'floor.min' => 'ชั้นต้องไม่เป็น 0 หรือต่ำกว่า :min',

            'type.required' => 'กรุณากรอกข้อมูล',

            'status.required' => 'กรุณากรอกข้อมูล',

            'monthly_rent.required' => 'กรุณากรอกข้อมูล',
            'monthly_rent.min' => 'ค่าเช่าต้องไม่ต่ำกว่า 500 บาท',
        ];

        $validator = Validator::make($request->all(), [
            // 'room_no' => ['required', Rule::unique('rooms', 'room_no')->ignore($id, 'id')],
            'floor' => 'required|numeric|min:1',
            'type' => 'required',
            'status' => 'required',
            'monthly_rent' => 'required|numeric|min:500',
        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('room/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $room = RoomModel::find($id);
            $room->update([
                'floor' => strip_tags($request->input('floor')),
                'type' => strip_tags($request->input('type')),
                'status' => strip_tags($request->input('status')),
                'monthly_rent' => strip_tags($request->input('monthly_rent')),
                'note' => strip_tags($request->input('note')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/room');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $room = RoomModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $room->delete();

            // ถ้ามี lease ผูกอยู่ ไม่ต้องไปให้ DB โยน 1451
            $hasLease = DB::table('leases')->where('room_id', $id)->exists();
            if ($hasLease) {
                Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถลบห้องนี้ได้ เนื่องจากมีสัญญาเช่าที่อ้างอิงอยู่');
                return redirect('/room');
            }

            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/room');
        } catch (QueryException $e) {
            // ห้าม return JSON/404 ที่นี่ ไม่งั้น swal ไม่โชว์
            if ($e->getCode() === '23000' && isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1451) {
                Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถลบห้องนี้ได้ เนื่องจากมีสัญญาเช่าที่อ้างอิงอยู่');
            } else {
                Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้');
            }
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
        return redirect('/room');
    } //remove 

    public function search(Request $request)
    {
        try {
            Paginator::useBootstrap();

            $keyword = trim((string) $request->input('keyword', ''));
            $by      = $request->input('by', 'all');

            // กันค่า by ที่ไม่อนุญาต
            $allowed = ['all', 'room_no', 'floor', 'type', 'status', 'rent', 'id'];
            if (!in_array($by, $allowed, true)) {
                $by = 'all';
            }

            $rooms = RoomModel::query();

            if ($keyword !== '') {
                switch ($by) {
                    case 'room_no':
                        $rooms->where('room_no', 'LIKE', '%' . $keyword . '%');
                        break;

                    case 'floor':
                        if (ctype_digit($keyword)) {
                            $rooms->where('floor', (int)$keyword);
                        } else {
                            $rooms->where('floor', 'LIKE', '%' . $keyword . '%');
                        }
                        break;

                    case 'type':
                        $rooms->where('type', 'LIKE', '%' . $keyword . '%');
                        break;

                    case 'status':
                        $rooms->where(function ($w) use ($keyword) {
                            $w->where('status', 'LIKE', '%' . strtoupper($keyword) . '%')
                                ->orWhere('status', 'LIKE', '%' . ucfirst(strtolower($keyword)) . '%')
                                ->orWhere('status', 'LIKE', '%' . strtolower($keyword) . '%');
                        });
                        break;

                    case 'rent':
                        if (is_numeric(str_replace([','], '', $keyword))) {
                            $num = (float) str_replace([','], '', $keyword);
                            $rooms->where('monthly_rent', $num);
                        } else {
                            $rooms->where('monthly_rent', 'LIKE', '%' . $keyword . '%');
                        }
                        break;

                    case 'id':
                        if (ctype_digit($keyword)) {
                            $rooms->where('id', (int)$keyword);
                        } else {
                            $rooms->whereRaw('1=0');
                        }
                        break;

                    case 'all':
                    default:
                        $rooms->where(function ($w) use ($keyword) {
                            $w->where('room_no', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('floor', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('type', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('status', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('monthly_rent', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('note', 'LIKE', '%' . $keyword . '%');
                            if (ctype_digit($keyword)) {
                                $w->orWhere('id', (int)$keyword);
                            }
                        });
                        break;
                }
            }

            $RoomList = $rooms->orderBy('id', 'desc')
                ->paginate(10)
                ->appends($request->query());

            return view('room.list', compact('RoomList'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} //class
