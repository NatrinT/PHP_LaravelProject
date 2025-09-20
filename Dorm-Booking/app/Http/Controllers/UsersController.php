<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\UsersModel;
use Illuminate\Pagination\Paginator;

class UsersController extends Controller
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
            $UsersList = UsersModel::orderBy('id', 'desc')->paginate(10); //order by & pagination
            return view('users.list', compact('UsersList'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    }



    public function adding()
    {
        return view('users.create');
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'email.required' => 'กรุณากรอกข้อมูล',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique' => 'Email ซ้ำ เพิ่มใหม่อีกครั้ง',

            'pass_hash.required' => 'กรุณากรอกข้อมูล',
            'pass_hash.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',

            'full_name.required' => 'กรุณากรอกข้อมูล',
            'full_name.min' =>  'กรอกข้อมูลขั้นต่ำ :min ตัว',

            'phone.required' => 'กรุณากรอกข้อมูล',
            'phone.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
            'phone.max' => 'กรอกข้อมูลขั้นต่ำ :max ตัว',

            'role.required' => 'กรุณากรอกข้อมูล',

        ];

        //rule 
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'pass_hash' => 'required|min:3',
            'full_name' => 'required|min:3',
            'phone' => 'required|min:10|max:10',
            'role' => 'required',
        ], $messages);

        //check vali 
        if ($validator->fails()) {
            return redirect('users/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            UsersModel::create([
                'email' => strip_tags($request->input('email')),
                'full_name' => strip_tags($request->input('full_name')),
                'phone' => strip_tags($request->input('phone')),
                'role' => strip_tags($request->input('role')),
                'pass_hash' => bcrypt($request->input('pass_hash')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/users');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun create



    public function edit($id)
    {
        try {
            //query data for form edit 
            $users = UsersModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($users)) {
                $id = $users->id;
                $name = $users->full_name;
                $phone = $users->phone;
                $email = $users->email;
                $status = $users->status;
                $role = $users->role;
                return view('users.edit', compact('id', 'name', 'phone', 'email', 'status', 'role'));
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
            'name.required' => 'กรุณากรอกข้อมูล',
            'name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'name.unique' => 'ชื่อนี้ถูกใช้งานแล้ว',  //ป้องกันแก้ซ้ำกับ row อื่นๆ จ้าาา

            'phone.required' => 'กรุณากรอกข้อมูล',
            'phone.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
            'phone.max' => 'กรอกข้อมูลสูงสุดไม่เกิน :max ตัว',

            'email.required' => 'กรุณากรอกข้อมูล',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',

            'status.required' => 'กรุณากรอกข้อมูล',
            'role.required' => 'กรุณากรอกข้อมูล',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'min:3',
                Rule::unique('users', 'full_name')->ignore($id, 'id'), //ห้ามแก้ซ้ำ
            ],

            'phone' => 'required|min:10|max:10',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id, 'id')],
            'status' => 'required',
            'role' => 'required',
        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('users/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $users = UsersModel::find($id);
            $users->update([
                'full_name' => strip_tags($request->input('name')), //column update 
                'phone' => strip_tags($request->input('phone')),
                'email' => strip_tags($request->input('email')),
                'status' => strip_tags($request->input('status')),
                'role' => strip_tags($request->input('role')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/users');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $user = UsersModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $user->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/users');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //remove 


    public function reset($id)
    {
        try {
            //query data for form edit 
            $user = UsersModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($user)) {

                $id = $user->id;
                $name = $user->full_name;
                $email = $user->email;

                return view('users.editPassword', compact('id', 'name', 'email'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func reset

    public function resetPassword($id, Request $request)
    {
        //vali msg 
        $messages = [
            'password.required' => 'กรุณากรอกข้อมูล',
            'password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',

            'password_confirmation.required' => 'กรุณากรอกข้อมูล',
            'password_confirmation.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:3|confirmed',
            'password_confirmation' => 'required|min:3',
        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('users/reset/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = UsersModel::find($id);
            $user->update([
                'pass_hash' => bcrypt($request->input('password')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('แก้ไขรหัสผ่านสำเร็จ');
            return redirect('/users');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            // return view('errors.404');
        }
    } //fun update 


} //class
