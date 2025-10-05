<?php

namespace App\Http\Controllers;

use App\Models\RoomModel;
use Illuminate\Http\Request;
use App\Models\LeaseModel;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    public function __construct()
    {
        // ใช middleware 'auth:admin' เพื่อบังคับใหตองล็อกอินในฐานะ admin กอนใชงาน
        // controller นี้
        // ถาไมล็อกอินหรือไมไดใช guard 'admin' จะถูก redirect ไปหนา login
        $this->middleware('auth:admin');
    }

    public function showCheckout(RoomModel $room, Request $req)
    {
        // ใส่ start_date/end_date ถ้ามี
        return view('content.bookingContent', [
            'room' => $room,
            'start_date' => $req->query('start_date'), // optional
            'end_date'   => $req->query('end_date'),   // optional
        ]);
    }

    public function processCheckout()
    {
        // ใส่ start_date/end_date ถ้ามี
        return view('content.myBookingContent');
    }
} //class
