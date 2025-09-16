<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //รับค่าจากฟอร์ม
use Illuminate\Support\Facades\Validator; //form validation
use RealRashid\SweetAlert\Facades\Alert; //sweet alert
use Illuminate\Support\Facades\Storage; //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator; //แบ่งหน้า
use App\Models\UsersModel;
use Illuminate\Support\Facades\Hash;

class AuthenController extends Controller
{

    public function index()
    {
        return view('home.login_page');
    }

    public function checkUser($email, $inputPassword){
        try {
            // ดึงผู้ใช้ตาม email
            $user = UsersModel::where('email', $email)->firstOrFail();

            // ตรวจสอบรหัสผ่าน
            if (Hash::check($inputPassword, $user->pass_hash)) {
                // รหัสผ่านถูกต้อง
                $id = $user->id;
                $email = $user->email;
                $full_name = $user->full_name;
                $phone = $user->phone;
                $role = $user->role;
                $status = $user->status;

                // ส่งค่าไป view
                return view('home.product_detail', compact(
                    'id', 'email', 'full_name', 'phone', 'role', 'status'
                ));
            } else {
                // รหัสผ่านไม่ถูกต้อง
                return redirect()->back()->withErrors(['password' => 'รหัสผ่านไม่ถูกต้อง']);
            }

        } catch (\Throwable $th) {
            return view('errors.404');
        }
    } // searchProduct

} //class
