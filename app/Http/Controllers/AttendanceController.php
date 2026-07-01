<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exports\RekapExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index()
    {
        $data = Attendance::orderBy('tanggal', 'desc')->get();

        return view('karyawan.riwayat', compact('data'));
    }

    public function rekap(Request $request)
{
    $data = Attendance::with('user')

        ->when($request->tanggal, function ($query) use ($request) {
            $query->whereDate('tanggal', $request->tanggal);
        })

        ->when($request->status, function ($query) use ($request) {
            $query->where('status', $request->status);
        })

        ->orderBy('tanggal', 'desc')
        ->get();

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
    $request->validate([
        'image' => 'required',
        'latitude' => 'nullable',
        'longitude' => 'nullable',
    ]);

    $image = str_replace('data:image/png;base64,', '', $request->image);
    $image = str_replace(' ', '+', $image);

    $imageName = time() . '.png';

    $folder = public_path('uploads/absensi');

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    file_put_contents(
        $folder.'/'.$imageName,
        base64_decode($image)
    );

    $jamMasuk = now();

    $status = $jamMasuk->format('H:i:s') > '08:00:00'
        ? 'Terlambat'
        : 'Hadir';

    $latitude = $request->latitude;
    $longitude = $request->longitude;

    if ($latitude == null || $longitude == null) {
        return response()->json([
            'success' => false,
            'message' => 'Lokasi tidak berhasil didapatkan.'
        ]);
    }

    $kantorLat = 1.050842;
    $kantorLng = 104.032611;

    $jarak = $this->hitungJarak(
        $latitude,
        $longitude,
        $kantorLat,
        $kantorLng
    );

    
    if ($jarak > 50000) {
        return response()->json([
            'success' => false,
            'message' => 'Anda berada di luar area perusahaan.'
        ]);
    }

    try {

        Attendance::create([
            'user_id' => auth()->id(),
            'nama' => auth()->user()->name,
            'tanggal' => now()->format('Y-m-d'),
            'jam_masuk' => $jamMasuk->format('H:i:s'),
            'foto_masuk' => $imageName,
            'status' => $status,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return response()->json([
            'success' => true
        ]);

}    catch (\Throwable $e) {

    return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
    ], 500);

}

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
        $folder.'/'.$imageName,
        base64_decode($image)
    );

    $absen = Attendance::where('user_id', auth()->id())
        ->whereDate('tanggal', now()->toDateString())
        ->first();

    if (!$absen) {
        return response()->json([
            'success' => false,
            'message' => 'Data absen masuk tidak ditemukan.'
        ]);
    }

    $jamPulang = now();

    $statusPulang = $jamPulang->format('H:i:s') < '17:00:00'
        ? 'Pulang Cepat'
        : 'Normal';

    $jamMasuk = Carbon::parse($absen->jam_masuk);

$interval = $jamMasuk->diff($jamPulang);

$totalJam = sprintf(
    '%02d:%02d:%02d',
    $interval->h,
    $interval->i,
    $interval->s
);
    $absen->jam_pulang = $jamPulang->format('H:i:s');
$absen->foto_pulang = $imageName;
$absen->status_pulang = $statusPulang;
$absen->total_jam = $totalJam;

$hasil = $absen->save();

dd(
    $hasil,
    $totalJam,
    $absen->toArray()
);
}

    public function export_excel(Request $request)
{
    return Excel::download(
        new RekapExport(
            $request->tanggal,
            $request->status
        ),
        'rekap_absensi.xlsx'
    );
}

   public function riwayat()
{
    $attendances = Attendance::where('user_id', auth()->id())
        ->latest()
        ->take(5)
        ->get();

    return view('karyawan.riwayat', compact('attendances'));
}

private function hitungJarak($lat1, $lon1, $lat2, $lon2)
{
    $earth = 6371000;

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a =
        sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) *
        cos(deg2rad($lat2)) *
        sin($dLon / 2) *
        sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earth * $c;
}
}