<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // TAMPIL DATA
    public function index()
    {
        $data = Attendance::all();
        return view('attendance', compact('data'));
    }

    // ABSEN MASUK
    public function masuk(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        Attendance::create([
            'nama' => $request->nama,
            'tanggal' => date('Y-m-d'),
            'jam_masuk' => date('H:i:s'),
        ]);

        return redirect('/attendance');
    }

    // ABSEN PULANG
    public function pulang($id)
    {
        $data = Attendance::find($id);
        $data->update([
            'jam_pulang' => date('H:i:s')
        ]);

        return redirect('/attendance');
    }
}