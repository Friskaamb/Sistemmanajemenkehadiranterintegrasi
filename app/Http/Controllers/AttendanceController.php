public function masuk(Request $request)
{
    // VALIDASI
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