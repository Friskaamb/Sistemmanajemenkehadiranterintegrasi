<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $absenHariIni = Attendance::whereDate('tanggal', today())
    ->first();
    return view('karyawan.dashboard', compact('absenHariIni'));
}


    public function admin()
    {
        $totalKaryawan = 247;
        $hadirHariIni = 234;
        $terlambat = 8;
        $tidakHadir = 5;

        return view('admin.dashboard', compact(
            'totalKaryawan', 
            'hadirHariIni', 
            'terlambat', 
            'tidakHadir'
        ));
    }

    public function data_karyawan()
    {
        return view('admin.karyawan');
    }
}