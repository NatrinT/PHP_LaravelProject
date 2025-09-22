<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
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
            $AnnouncementList = AnnouncementModel::orderBy('id', 'desc')->paginate(10); //order by & pagination
            return view('announcement.list', compact('AnnouncementList'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    }

    public function adding()
    {
        return view('announcement.create');
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'title.required' => 'กรุณากรอกข้อมูล',
            'title.unique' => 'หัวข้อซ้ำ เพิ่มใหม่อีกครั้ง',

            'body.required' => 'กรุณากรอกข้อมูล',
            'body.min' => 'ข้อความไม่เป็น 0 หรือต่ำกว่า :min',

            'image.required' => 'กรุณาใส่ภาพประกอบ',
        ];


        //rule 
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:announcement',
            'body' => 'required|min:1',
            'image' => 'required|file|mimes:jpg,jpeg,png,webp|max:5120',
        ], $messages);


        //check vali 
        if ($validator->fails()) {
            return redirect('announcement/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $path = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('uploads/announcement', 'public');
            }

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            AnnouncementModel::create([
                'title' => strip_tags($request->input('title')),
                'body' => strip_tags($request->input('body')),
                'image' => $path,
            ]);
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/announcement');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun create



    public function edit($id)
    {
        try {
            //query data for form edit 
            $announcement = AnnouncementModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($announcement)) {
                $id = $announcement->id;
                $title = $announcement->title;
                $body = $announcement->body;
                $image = $announcement->image;
                $updated_at = $announcement->updated_at;
                return view('announcement.edit', compact('id', 'title', 'body', 'image', 'updated_at'));
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
            'title.required' => 'กรุณากรอกข้อมูล',
            'title.unique' => 'หัวข้อซ้ำ เพิ่มใหม่อีกครั้ง',

            'body.required' => 'กรุณากรอกข้อมูล',
            'body.min' => 'ข้อความไม่เป็น 0 หรือต่ำกว่า :min',
        ];


        //rule 
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:announcement',
            'body' => 'required|min:1',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('announcement/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $announcement = AnnouncementModel::find($id);
            $path = $announcement->image;

            // ถ้ามีอัปโหลดใหม่ ค่อยอัปเดต path และลบไฟล์เก่า
            if ($request->hasFile('image')) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $path = $request->file('image')->store('uploads/announcement', 'public');
            }

            $announcement->update([
                'title' => strip_tags($request->title),
                'body'  => strip_tags($request->body),
                'image' => $path, // ถ้าไม่ได้อัปใหม่ จะเป็นของเดิม
            ]);

            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/announcement');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $announcement = AnnouncementModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $announcement->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/announcement');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //remove 

} //class
