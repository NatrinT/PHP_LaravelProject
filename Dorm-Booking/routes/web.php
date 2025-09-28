<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UsersController;

//home page
Route::get('/', [HomeController::class, 'index']);

//login


// product home page
Route::get('/detail/{id}', [HomeController::class, 'detail']);
Route::get('/search', [HomeController::class, 'searchProduct']);

Route::get('/users', [UsersController::class, 'index']);
Route::get('/users/adding', [UsersController::class, 'adding']);
Route::post('/users', [UsersController::class, 'create']);

// ✅ ต้องมาก่อน {id}
Route::get('/users/search', [UsersController::class, 'search'])->name('users.search');
Route::get('/users/{id}', [UsersController::class, 'edit']);
Route::put('/users/{id}', [UsersController::class, 'update']);
Route::delete('/users/remove/{id}', [UsersController::class, 'remove']);
Route::get('/users/reset/{id}', [UsersController::class, 'reset'])->name('user.reset');
Route::put('/users/reset/{id}', [UsersController::class, 'resetPassword']);


//rooms crud
Route::get('/room', [RoomController::class, 'index']);
Route::get('/room/search', [RoomController::class, 'search'])->name('rooms.search');
Route::get('/room/adding',  [RoomController::class, 'adding']);
Route::post('/room',  [RoomController::class, 'create']);
Route::get('/room/{id}',  [RoomController::class, 'edit']);
Route::put('/room/{id}',  [RoomController::class, 'update']);
Route::delete('/room/remove/{id}',  [RoomController::class, 'remove']);
Route::get('/room/reset/{id}',  [RoomController::class, 'reset']);
Route::put('/room/reset/{id}',  [RoomController::class, 'resetPassword']);

//lease crud
Route::get('/lease', [LeaseController::class, 'index']);
Route::get('/lease/search', [LeaseController::class, 'search'])->name('leases.search');
Route::get('/lease/adding',  [LeaseController::class, 'adding']);
Route::post('/lease',  [LeaseController::class, 'create']);
Route::get('/lease/{id}',  [LeaseController::class, 'edit']);
Route::put('/lease/{id}',  [LeaseController::class, 'update']);
Route::delete('/lease/remove/{id}',  [LeaseController::class, 'remove']);
Route::get('/lease/reset/{id}',  [LeaseController::class, 'reset']);
Route::put('/lease/reset/{id}',  [LeaseController::class, 'resetPassword']);

//invoice crud
Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/search', [InvoiceController::class, 'index'])->name('invoices.search');
Route::get('/invoice/adding',  [InvoiceController::class, 'adding']);
Route::post('/invoice',  [InvoiceController::class, 'create']);
Route::get('/invoice/{id}',  [InvoiceController::class, 'edit']);
Route::put('/invoice/{id}',  [InvoiceController::class, 'update']);
Route::delete('/invoice/remove/{id}',  [InvoiceController::class, 'remove']);
Route::get('/invoice/reset/{id}',  [InvoiceController::class, 'reset']);
Route::put('/invoice/reset/{id}',  [InvoiceController::class, 'resetPassword']);

//announcement crud
Route::get('/announcement', [AnnouncementController::class, 'index']);
Route::get('/announcement/adding',  [AnnouncementController::class, 'adding']);
Route::post('/announcement',  [AnnouncementController::class, 'create']);
Route::get('/announcement/{id}',  [AnnouncementController::class, 'edit']);
Route::put('/announcement/{id}',  [AnnouncementController::class, 'update']);
Route::delete('/announcement/remove/{id}',  [AnnouncementController::class, 'remove']);
Route::get('/announcement/reset/{id}',  [AnnouncementController::class, 'reset']);
Route::put('/announcement/reset/{id}',  [AnnouncementController::class, 'resetPassword']);

Route::get('/dashboard', [HomeController::class, 'backend'])->name('dashboard');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/checkmail', [AuthController::class, 'checkmail'])->name('users.checkmail');
//ทำไมต้องมี name('login') ?
//เวลาใช้ auth middleware ถ้า user ยังไม่ login → Laravel จะ redirect ไปหา route ที่ชื่อว่า login โดยอัตโนมัติ
//ถ้าไม่เจอ → มันก็โยน error Route [login] not defined.
 
//login เสร็จไปหน้า Dashboard
Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'backend'])->name('dashboard');
});

//admin crud
// Route::get('/admin', [AdminController::class, 'index']);
// Route::get('/admin/adding',  [AdminController::class, 'adding']);
// Route::post('/admin',  [AdminController::class, 'create']);
// Route::get('/admin/{id}',  [AdminController::class, 'edit']);
// Route::put('/admin/{id}',  [AdminController::class, 'update']);
// Route::delete('/admin/remove/{id}',  [AdminController::class, 'remove']);
// Route::get('/admin/reset/{id}',  [AdminController::class, 'reset']);
// Route::put('/admin/reset/{id}',  [AdminController::class, 'resetPassword']);

//product crud
// Route::get('/product', [ProductController::class, 'index']);
// Route::get('/product/adding',  [ProductController::class, 'adding']);
// Route::post('/product',  [ProductController::class, 'create']);
// Route::get('/product/{id}',  [ProductController::class, 'edit']);
// Route::put('/product/{id}',  [ProductController::class, 'update']);
// Route::delete('/product/remove/{id}',  [ProductController::class, 'remove']);
// Route::get('/product/reset/{id}',  [ProductController::class, 'reset']);
// Route::put('/product/reset/{id}',  [ProductController::class, 'resetPassword']);