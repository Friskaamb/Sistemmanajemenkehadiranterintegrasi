<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListBarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
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
| Praktikum List Barang (Routes → Controller → View)
|--------------------------------------------------------------------------
*/

Route::get('/listbarang/{id}/{nama}', [ListBarangController::class, 'tampilkan']);


/*
|--------------------------------------------------------------------------
| PBL - Sistem Manajemen Kehadiran Karyawan
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/attendance', [AttendanceController::class, 'index']);