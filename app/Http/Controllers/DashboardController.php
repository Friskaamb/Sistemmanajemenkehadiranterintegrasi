<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $kehadiranBulanIni = 18; 
        $sisaCuti = 8;
        $keterlambatan = 2;

        return view('karyawan.dashboard', compact('kehadiranBulanIni', 'sisaCuti', 'keterlambatan'));
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