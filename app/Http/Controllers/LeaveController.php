<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index()
{
    $izins = Leave::where('user_id', Auth::id())
        ->latest()
        ->get();

    // Jatah cuti bertambah 1 hari setiap bulan
    $jatahTahunIni = now()->month;

    // Hitung cuti yang sudah disetujui
    $cutiTerpakai = Leave::where('user_id', Auth::id())
        ->where('jenis_izin', 'Cuti')
        ->where('status', 'Disetujui')
        ->get()
        ->sum(function ($cuti) {
            return Carbon::parse($cuti->tgl_mulai)
                ->diffInDays(
                    Carbon::parse($cuti->tgl_selesai)
                ) + 1;
        });

    $sisaCuti = $jatahTahunIni - $cutiTerpakai;

    if ($sisaCuti < 0) {
        $sisaCuti = 0;
    }

    return view('karyawan.izin', compact(
        'izins',
        'sisaCuti'
    ));
}

    public function store(Request $request)
    {
        $request->validate([
    'jenis_izin' => 'required',
    'tgl_mulai' => 'required|date',
    'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
    'alasan' => 'required',
    'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
], [
    'jenis_izin.required' => 'Jenis izin wajib dipilih.',
    'tgl_mulai.required' => 'Tanggal mulai wajib diisi.',
    'tgl_selesai.required' => 'Tanggal selesai wajib diisi.',
    'tgl_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
    'alasan.required' => 'Alasan wajib diisi.',
    'lampiran.max' => 'Ukuran lampiran maksimal 5 MB.',
    'lampiran.mimes' => 'Lampiran harus berupa JPG, JPEG, PNG, atau PDF.'
]);

        $namaFile = null;

        if ($request->hasFile('lampiran')) {
            $namaFile = time().'_'.$request->file('lampiran')->getClientOriginalName();
            $request->file('lampiran')->move(public_path('uploads'), $namaFile);
        }
        if ($request->jenis_izin == 'Sakit' && !$request->hasFile('lampiran')) {
           return back()->with('error',
           'Izin sakit wajib melampirkan surat dokter');
        }
        if ($request->jenis_izin == 'Cuti') {
            $mulai = Carbon::parse($request->tgl_mulai);

        if (now()->diffInDays($mulai, false) < 3) {
            return back()->with('error',
            'Pengajuan cuti minimal 3 hari sebelum tanggal mulai');
        }
    }
        Leave::create([
            'user_id' => Auth::id(),
            'jenis_izin' => $request->jenis_izin,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'alasan' => $request->alasan,
            'lampiran' => $namaFile,
            'status' => 'Pending'
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim');
    }

  public function persetujuan()
{
    $izins = Leave::with('user')
        ->latest()
        ->get();

    return view('admin.persetujuan', compact('izins'));
}

    public function update_status(Request $request, $id)
{
    $izin = Leave::findOrFail($id);

    $izin->status = $request->status;

    $izin->save();

    return back()->with('success', 'Status berhasil diperbarui');
}
}