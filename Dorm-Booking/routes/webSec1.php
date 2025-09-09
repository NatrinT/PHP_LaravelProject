<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;

//home page
Route::get('/', [TestController::class, 'index']);

//test crud
Route::get('/test', [TestController::class, 'index']);
Route::get('/test/adding',  [TestController::class, 'adding']);
Route::post('/test',  [TestController::class, 'create']);
Route::get('/test/{id}',  [TestController::class, 'edit']);
Route::put('/test/{id}',  [TestController::class, 'update']);
Route::delete('/test/remove/{id}',  [TestController::class, 'remove']);

//admin crud
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/adding',  [AdminController::class, 'adding']);
Route::post('/admin',  [AdminController::class, 'create']);
Route::get('/admin/{id}',  [AdminController::class, 'edit']);
Route::put('/admin/{id}',  [AdminController::class, 'update']);
Route::delete('/admin/remove/{id}',  [AdminController::class, 'remove']);
Route::get('/admin/reset/{id}',  [AdminController::class, 'reset']);
Route::put('/admin/reset/{id}',  [AdminController::class, 'resetPassword']);
