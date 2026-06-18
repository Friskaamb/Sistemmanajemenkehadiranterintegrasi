<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| 1. AUTHENTICATION (Login & Register)
|--------------------------------------------------------------------------
*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login.form');

Route::post('/login', [LoginController::class, 'proses_login'])
    ->name('proses.login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| 2. PORTAL KARYAWAN (User Dashboard)
|--------------------------------------------------------------------------
*/

Route::prefix('karyawan')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('karyawan.dashboard');

    // Riwayat Kehadiran
    Route::get('/riwayat', [AttendanceController::class, 'riwayat'])
        ->name('riwayat');
    // Izin & Cuti
    Route::get('/izin', [LeaveController::class, 'index'])
        ->name('karyawan.izin');

    Route::post('/izin/simpan', [LeaveController::class, 'store'])
        ->name('karyawan.izin.simpan');

    // Profil
    Route::get('/profil', [ProfileController::class, 'index'])
        ->name('karyawan.profil');

    Route::post('/profil/update', [ProfileController::class, 'update'])
        ->name('karyawan.profil.update');

    // Absensi
    Route::post('/absen/masuk', [AttendanceController::class, 'masuk'])
        ->name('karyawan.absen.masuk');

    Route::post('/absen/pulang', [AttendanceController::class, 'pulang'])
        ->name('karyawan.absen.pulang');

    Route::post('/absen/masuk-webcam', [AttendanceController::class, 'masukWebcam'])
    ->name('karyawan.absen.masuk.webcam');

Route::post('/absen/pulang-webcam', [AttendanceController::class, 'pulangWebcam'])
    ->name('karyawan.absen.pulang.webcam');
});


/*
|--------------------------------------------------------------------------
| 3. ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');

    // Data Karyawan
    Route::get('/karyawan', [DashboardController::class, 'data_karyawan'])
        ->name('admin.karyawan');

    Route::post('/karyawan/tambah', [DashboardController::class, 'tambah_karyawan'])
        ->name('admin.karyawan.tambah');

    // Rekap Absensi
    Route::get('/rekap', [AttendanceController::class, 'rekap'])
        ->name('admin.rekap');

    Route::get('/rekap/export-pdf', [AttendanceController::class, 'export_pdf'])
        ->name('admin.rekap.pdf');

    Route::get('/rekap/export-excel', [AttendanceController::class, 'export_excel'])
        ->name('admin.rekap.excel');

    // Persetujuan Cuti
    Route::get('/persetujuan', [LeaveController::class, 'persetujuan'])
        ->name('admin.persetujuan');

    Route::post('/persetujuan/update/{id}', [LeaveController::class, 'update_status'])
        ->name('admin.persetujuan.update');
});


/*
|--------------------------------------------------------------------------
| DEVELOPMENT ONLY
|--------------------------------------------------------------------------
*/

Route::get('/test-view', function () {
    return view('welcome');
});