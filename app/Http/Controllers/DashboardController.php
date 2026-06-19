<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    $totalKaryawan = User::where('role', 'karyawan')->count();

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
    $karyawans = User::with('division')
        ->where('role', '!=', 'admin')
        ->get();

    $divisions = Division::all();

    return view(
        'admin.karyawan',
        compact('karyawans', 'divisions')
    );
}

public function create_karyawan()
{
    $divisions = Division::all();

    return view('admin.tambah_karyawan', compact('divisions'));
}

public function storekaryawan(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'nik' => 'required|unique:users,nik',
        'division_id' => 'required',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'nik' => $request->nik,
        'division_id' => $request->division_id,
        'password' => Hash::make('12345678'),
        'role' => 'karyawan',
    ]);

    return redirect()
    ->route('admin.karyawan')
    ->with('success', 'Karyawan berhasil ditambahkan');}
}