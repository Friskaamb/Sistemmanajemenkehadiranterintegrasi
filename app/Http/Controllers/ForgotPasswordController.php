<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak ditemukan di sistem',
        ]);

        // Generate token
        $token = Str::random(64);
        
        // Simpan ke password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Return dengan token (untuk development, langsung bisa klik link)
        // Di production, token dikirim via email
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        return redirect()->back()->with('status', 'Link reset password telah dikirim! (Development: ' . $resetUrl . ')');
    }

    public function showResetForm($token, $email)
    {
        // Verify token exists dan belum expired (1 jam)
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$passwordReset) {
            return redirect('/login')->with('error', 'Link reset password tidak valid atau sudah expired');
        }

        if (!Hash::check($token, $passwordReset->token)) {
            return redirect('/login')->with('error', 'Link reset password tidak valid');
        }

        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            return redirect('/login')->with('error', 'Link reset password sudah expired, silakan minta link baru');
        }

        return view('auth.reset', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak ditemukan',
            'password.required' => 'Kata sandi harus diisi',
            'password.min' => 'Kata sandi minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
        ]);

        // Verify token
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return redirect('/login')->with('error', 'Link reset password tidak valid');
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda');
    }
}
