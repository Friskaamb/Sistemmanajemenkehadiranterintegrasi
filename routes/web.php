<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| 1. AUTHENTICATION (Login & Register)
|--------------------------------------------------------------------------
*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'proses_login']); // Logic login
Route::get('/register', function () { return view('auth.register'); });
Route::get('/logout', [LoginController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| 2. PORTAL KARYAWAN (User Dashboard)
|--------------------------------------------------------------------------
*/
Route::prefix('karyawan')->group(function () {
    // Foto 1: Beranda / Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('karyawan.dashboard');
    
    // Foto 2: Riwayat Kehadiran
    Route::get('/riwayat', [AttendanceController::class, 'index'])->name('karyawan.riwayat');
    
    // Foto 3: Izin & Cuti
    Route::get('/izin', [LeaveController::class, 'index'])->name('karyawan.izin');
    Route::post('/izin/simpan', [LeaveController::class, 'store']); // Simpan pengajuan cuti
    
    // Foto 4: Profil & Ganti Password
    Route::get('/profil', [ProfileController::class, 'index'])->name('karyawan.profil');
    Route::post('/profil/update', [ProfileController::class, 'update']); // Update password/emergency contact

    // Logic Tombol Absen (POST & GET)
    Route::post('/absen/masuk', [AttendanceController::class, 'masuk']);
    Route::post('/absen/pulang', [AttendanceController::class, 'pulang']);
});

/*
|--------------------------------------------------------------------------
| 3. ADMIN DASHBOARD (PT.DFL Management)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    // Foto Admin 1: Ringkasan & Analytics
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // Foto Admin 2: Manajemen Data Karyawan
    Route::get('/karyawan', [DashboardController::class, 'data_karyawan'])->name('admin.karyawan');
    Route::post('/karyawan/tambah', [DashboardController::class, 'tambah_karyawan']);

    // Foto Admin 3: Rekap Absensi Lengkap (Filter & GPS)
    Route::get('/rekap', [AttendanceController::class, 'rekap'])->name('admin.rekap');
    Route::get('/rekap/export-pdf', [AttendanceController::class, 'export_pdf']);
    Route::get('/rekap/export-excel', [AttendanceController::class, 'export_excel']);

    // Foto Admin 4: Persetujuan Cuti
    Route::get('/persetujuan', [LeaveController::class, 'persetujuan'])->name('admin.persetujuan');
    Route::post('/persetujuan/update/{id}', [LeaveController::class, 'update_status']);
});

/*
|--------------------------------------------------------------------------
| DEVELOPMENT ONLY (Test View)
|--------------------------------------------------------------------------
*/
Route::get('/test-view', function () {
    return view('welcome');}


Route::get('/', [HomeController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contact']);

/*
|--------------------------------------------------------------------------
| CONTOH / TEST
|--------------------------------------------------------------------------
*/

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

// LOGIN (pakai AuthController aja, yang lama dihapus)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// HALAMAN YANG HARUS LOGIN 🔒
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index']);
    Route::post('/attendance/masuk', [AttendanceController::class, 'masuk']);
    Route::get('/attendance/pulang/{id}', [AttendanceController::class, 'pulang']);
});