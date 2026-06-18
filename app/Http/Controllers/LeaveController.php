<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $izins = Leave::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('karyawan.izin', compact('izins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'alasan' => 'required',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $namaFile = null;

        if ($request->hasFile('lampiran')) {
            $namaFile = time().'_'.$request->file('lampiran')->getClientOriginalName();
            $request->file('lampiran')->move(public_path('uploads'), $namaFile);
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
        return view('admin.persetujuan');
    }

    public function update_status(Request $request, $id)
    {
        return back();
    }
}