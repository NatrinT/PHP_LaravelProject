<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TestModel;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    // if ($user->role === 'admin') {
        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            session(['user_id' => $user->id, 'user_name' => $user->full_name]);
            return redirect()->intended('/dashboard');
        }
    // } else {
    //     if (Hash::check($request->password, $user->pass_hash)) {
    //         session(['user_id' => $user->id, 'user_name' => $user->full_name]);
    //         return redirect('/');
    //     }
    // }

    return back()->withErrors([
        'email' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'
    ])->withInput();
}




    public function checkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $exists = \App\Models\UsersModel::where('email', $request->email)->exists();

    if ($exists) {
        // ถ้ามี email อยู่ใน DB
        // สามารถส่งลิงก์รีเซ็ตรหัสผ่าน หรือข้อความยืนยัน
        return back()->with('success', 'ระบบได้ส่งลิงก์รีเซ็ตรหัสผ่านไปยังอีเมลของคุณแล้ว');
    } else {
        return back()->withErrors(['email' => 'ไม่พบอีเมลในระบบ'])->withInput();
    }
}


    public function logout(Request $request)
    {
        session()->flush(); // ล้าง session ทั้งหมด
        return redirect('/');
    }
}
