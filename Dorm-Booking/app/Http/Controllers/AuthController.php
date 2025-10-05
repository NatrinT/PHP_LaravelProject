<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login'); // ชี้ไป view login แทน layout
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:3',
        ]);

        $user = UsersModel::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'ไม่พบผู้ใช้'])->withInput();
        }

        if ($user->role === 'ADMIN' || $user->role === 'STAFF') {
            if (Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {
                $request->session()->regenerate();
                session(['user_id' => $user->id, 'user_name' => $user->full_name, 'user_role' => $user->role]);
                return redirect()->intended('/dashboard');
            }
        } else {
            if (Hash::check($request->password, $user->pass_hash)) {
                session(['user_id' => $user->id, 'user_name' => $user->full_name, 'user_role' => $user->role]);
                return redirect('/');
            }
        }

        return back()->withErrors([
            'email' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'
        ])->withInput();
    }




    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $exists = UsersModel::where('email', $request->email)->exists();

        if ($exists) {
            // ถ้ามี email อยู่ใน DB
            // สามารถส่งลิงก์รีเซ็ตรหัสผ่าน หรือข้อความยืนยัน
            return back()->with('success', 'ระบบได้ส่งลิงก์รีเซ็ตรหัสผ่านไปยังอีเมลของคุณแล้ว');
        } else {
            return back()->withErrors(['email' => 'ไม่พบอีเมลในระบบ'])->withInput();
        }
    }

    public function register(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'email.required' => 'กรุณากรอกข้อมูล',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique' => 'Email ซ้ำ เพิ่มใหม่อีกครั้ง',

            'password.required' => 'กรุณากรอกข้อมูล',
            'password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',

            'full_name.required' => 'กรุณากรอกข้อมูล',
            'full_name.min' =>  'กรอกข้อมูลขั้นต่ำ :min ตัว',

            'phone.required' => 'กรุณากรอกข้อมูล',
            'phone.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
            'phone.max' => 'กรอกข้อมูลขั้นต่ำ :max ตัว',

        ];

        //rule 
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
            'full_name' => 'required|min:3',
            'phone' => 'required|min:10|max:10',
        ], $messages);

        //check vali 
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            UsersModel::create([
                'email' => strip_tags($request->input('email')),
                'full_name' => strip_tags($request->input('full_name')),
                'phone' => strip_tags($request->input('phone')),
                'role' => 'MEMBER',
                'pass_hash' => bcrypt($request->input('password')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('สมัครสมาชิกเรียบร้อย', 'กรุณาเข้าสู่ระบบ');
            return redirect('/');
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun create


    public function logout(Request $request)
    {
        session()->flush(); // ล้าง session ทั้งหมด
        return redirect('/');
    }
}
