<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $cekAbsen = Attendance::where('user_id', Auth::id())
            ->whereDate('tanggal', Carbon::today())
            ->first();

        if ($cekAbsen) {
            return back()->with('error', 'Anda sudah absen masuk hari ini');
        }

        $namaFoto = time() . '.' . $request->foto->extension();

        $request->foto->move(
            public_path('uploads/absensi'),
            $namaFoto
        );

        Attendance::create([
            'user_id' => Auth::id(),
            'nama' => Auth::user()->name,
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'jam_masuk' => Carbon::now()->format('H:i:s'),
            'foto_masuk' => $namaFoto,
            'status' => Carbon::now()->format('H:i') > '08:00'
                ? 'Terlambat'
                : 'Hadir',
            'gps_status' => 'Verified'
        ]);

        return redirect()
            ->route('karyawan.dashboard')
            ->with('success', 'Absen masuk berhasil');
    }

    public function pulang(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $absen = Attendance::where('user_id', Auth::id())
            ->whereDate('tanggal', Carbon::today())
            ->first();

        if (!$absen) {
            return back()->with(
                'error',
                'Silakan absen masuk terlebih dahulu'
            );
        }

        if ($absen->jam_pulang) {
            return back()->with(
                'error',
                'Anda sudah absen pulang hari ini'
            );
        }

        $namaFoto = 'pulang_' . time() . '.' .
            $request->foto->extension();

        $request->foto->move(
            public_path('uploads/absensi'),
            $namaFoto
        );

        $jamMasuk = Carbon::parse($absen->jam_masuk);
        $jamPulang = Carbon::now();

        $absen->update([
            'jam_pulang' => $jamPulang->format('H:i:s'),
            'foto_pulang' => $namaFoto,
            'total_jam' => $jamMasuk->diffInHours($jamPulang)
        ]);

        return redirect()
            ->route('karyawan.dashboard')
            ->with('success', 'Absen pulang berhasil');
    }
    public function masukWebcam(Request $request)
{
    $image = $request->image;

    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    $imageName = time() . '.png';

    $folder = public_path('uploads/absensi');

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    file_put_contents(
        $folder . '/' . $imageName,
        base64_decode($image)
    );

    $jamMasuk = now();

$status = $jamMasuk->format('H:i:s') > '08:00:00'
    ? 'Terlambat'
    : 'Hadir';

Attendance::create([
    'user_id' => auth()->id(),
    'nama' => auth()->user()->name,
    'tanggal' => now()->format('Y-m-d'),
    'jam_masuk' => $jamMasuk->format('H:i:s'),
    'foto_masuk' => $imageName,
    'status' => $status,
    'gps_status' => 'Verified'
]);

    return response()->json([
        'success' => true
    ]);
}

public function pulangWebcam(Request $request)
{
    $image = $request->image;

    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    $imageName = 'pulang_' . time() . '.png';

    $folder = public_path('uploads/absensi');

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    file_put_contents(
        $folder . '/' . $imageName,
        base64_decode($image)
    );

    $absen = Attendance::where('user_id', auth()->id())
        ->whereDate('tanggal', now())
        ->first();

    if ($absen) {
        $jamPulang = now();

$statusPulang = $jamPulang->format('H:i:s') < '17:00:00'
    ? 'Pulang Cepat'
    : 'Normal';

$absen->update([
    'jam_pulang' => $jamPulang->format('H:i:s'),
    'foto_pulang' => $imageName,
    'status_pulang' => $statusPulang
]);
    }

    return response()->json([
        'success' => true
    ]);
}

    public function export_pdf()
    {
        return back()->with('success', 'Fitur export PDF belum dibuat');
    }

    public function export_excel()
    {
        return back()->with('success', 'Fitur export Excel belum dibuat');
    }
    public function riwayat()
{
    $attendances = Attendance::where('user_id', auth()->id())
        ->latest()
        ->take(5)
        ->get();

    return view('karyawan.riwayat', compact('attendances'));
}
}