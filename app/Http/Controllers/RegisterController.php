<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'nik' => 'required|string|unique:users,nik|max:50',
                'phone' => 'nullable|string|max:20',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'name.required' => 'Nama lengkap harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar, coba email lain',
                'nik.required' => 'NIK harus diisi',
                'nik.unique' => 'NIK sudah terdaftar, coba NIK lain',
                'password.required' => 'Kata sandi harus diisi',
                'password.min' => 'Kata sandi minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
            ]);

            // Buat user baru
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'nik' => $validated['nik'],
                'phone' => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => 'karyawan',
                'status' => 'aktif',
            ]);

            // Auto login setelah register
            Auth::login($user);

            return redirect()->route('karyawan.dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
