<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //รับค่าจากฟอร์ม
use Illuminate\Support\Facades\Validator; //form validation
use RealRashid\SweetAlert\Facades\Alert; //sweet alert
use Illuminate\Support\Facades\Storage; //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator; //แบ่งหน้า
use App\Models\ProductModel; //model



class HomeController extends Controller
{

    public function index()
    {
        return view('home.homepage');
    }

     public function backend()
    {
        return view('layouts.backend');
    }
    
} //class
