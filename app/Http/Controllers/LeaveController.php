<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index()
    {
        return view('karyawan.izin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'alasan' => 'required',
            'lampiran' => 'nullable|image|mimes:jpg,png,jpeg,pdf|max:2048'
        ]);

        $namaFile = null;
        if ($request->hasFile('lampiran')) {
            $namaFile = time() . '_' . $request->file('lampiran')->getClientOriginalName();
            $request->file('lampiran')->move(public_path('uploads'), $namaFile);
        }

        return back();
    }

    public function persetujuan()
    {
        $permintaan = [
            [
                'nama' => 'Budi Santoso', 
                'nik' => 'EMP-2024-015', 
                'jenis' => 'Cuti Tahunan', 
                'tgl' => '25-27 April 2026', 
                'alasan' => 'Liburan keluarga', 
                'initial' => 'BS'
            ],
            [
                'nama' => 'Ani Wijaya', 
                'nik' => 'EMP-2024-032', 
                'jenis' => 'Sakit', 
                'tgl' => '23 April 2026', 
                'alasan' => 'Demam dan flu', 
                'initial' => 'AW'
            ],
            [
                'nama' => 'Rudi Hartono', 
                'nik' => 'EMP-2024-048', 
                'jenis' => 'Izin Pribadi', 
                'tgl' => '24 April 2026', 
                'alasan' => 'Keperluan keluarga', 
                'initial' => 'RH'
            ],
        ];

        return view('admin.persetujuan', compact('permintaan'));
    }

    public function update_status(Request $request, $id)
    {
        return back();
    }
}