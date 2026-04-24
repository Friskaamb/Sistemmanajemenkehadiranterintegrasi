<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('karyawan.profil');
    }

    public function update(Request $request)
    {
        // Nantinya di sini validasi password lama & baru
        return back()->with('success', 'Profil/Password berhasil diperbarui!');
    }
}