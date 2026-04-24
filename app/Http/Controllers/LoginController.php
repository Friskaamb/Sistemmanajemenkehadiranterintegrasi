<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function proses_login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Logic login dummy (nanti diganti pakai Auth::attempt)
        if ($request->email == 'admin@ptdfl.com' && $request->password == 'admin123') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('karyawan.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}