<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
{
    $absenHariIni = Attendance::where('user_id', Auth::id())
        ->whereDate('tanggal', today())
        ->first();

    $hadirBulanIni = Attendance::where('user_id', Auth::id())
        ->whereMonth('tanggal', now()->month)
        ->count();

    $terlambatBulanIni = Attendance::where('user_id', Auth::id())
        ->whereMonth('tanggal', now()->month)
        ->where('status', 'Terlambat')
        ->count();

    return view('karyawan.dashboard', compact(
        'absenHariIni',
        'hadirBulanIni',
        'terlambatBulanIni'
    ));
}


    public function admin()
{
    $totalKaryawan = User::count();

    $hadirHariIni = Attendance::whereDate(
        'tanggal',
        today()
    )->count();

    $terlambat = Attendance::whereDate(
        'tanggal',
        today()
    )
    ->where('status', 'Terlambat')
    ->count();

    $tidakHadir = max(
        0,
        $totalKaryawan - $hadirHariIni
    );
    $absensiTerbaru = Attendance::latest()
    ->take(10)
    ->get();
$divisions = Division::withCount('users')->get();
    return view('admin.dashboard', compact(
    'totalKaryawan',
    'hadirHariIni',
    'terlambat',
    'tidakHadir',
    'absensiTerbaru',
    'divisions'
));
}

    public function data_karyawan()
    {
        return view('admin.karyawan');
    }
}