<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListBarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contact']);

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/user/{id}', function ($id) {
    return 'User dengan ID ' . $id;
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Admin Dashboard';
    });

    Route::get('/users', function () {
        return 'Admin Users';
    });
});

/*
|--------------------------------------------------------------------------
| LIST BARANG
|--------------------------------------------------------------------------
*/

Route::get('/listbarang/{id}/{nama}', [ListBarangController::class, 'tampilkan']);
Route::get('/barang', [ListBarangController::class, 'tampilkan']);

/*
|--------------------------------------------------------------------------
| PRAKTIKUM VIEW (WAJIB)
|--------------------------------------------------------------------------
*/

Route::view('/home', 'home');
Route::view('/about', 'about');
Route::view('/product', 'product');
Route::view('/contact', 'contact');
Route::view('/register', 'register');

/*
|--------------------------------------------------------------------------
| SISTEM KEHADIRAN
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [LoginController::class, 'index']);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);

// Attendance
Route::get('/attendance', [AttendanceController::class, 'index']);
Route::post('/attendance/masuk', [AttendanceController::class, 'masuk']);
Route::get('/attendance/pulang/{id}', [AttendanceController::class, 'pulang']);