<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $data = Attendance::orderBy('tanggal', 'desc')->get();
        return view('karyawan.riwayat', compact('data'));
    }

    public function rekap()
    {
        $data = Attendance::orderBy('tanggal', 'desc')->get();
        return view('admin.rekap', compact('data'));
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable'
        ]);

        Attendance::create([
            'user_id' => auth()->id() ?? 1,
            'nama' => $request->nama,
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'jam_masuk' => Carbon::now()->format('H:i:s'),
            'status' => Carbon::now()->format('H:i') > '08:00' ? 'Terlambat' : 'Hadir',
            'gps_status' => 'Verified',
        ]);

        return redirect()->route('karyawan.dashboard');
    }

    public function pulang(Request $request)
    {
        $absen = Attendance::where('user_id', auth()->id() ?? 1)
                            ->whereDate('tanggal', Carbon::today())
                            ->whereNull('jam_pulang')
                            ->first();

        if ($absen) {
            $jamMasuk = Carbon::parse($absen->jam_masuk);
            $jamPulang = Carbon::now();
            $totalJam = $jamMasuk->diffInHours($jamPulang);

            $absen->update([
                'jam_pulang' => $jamPulang->format('H:i:s'),
                'total_jam' => $totalJam
            ]);
        }

        return redirect()->route('karyawan.dashboard');
    }
}