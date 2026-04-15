@extends('layouts.app')

@section('content')

<div style="max-width:900px; margin:auto; margin-top:40px;">

    <!-- Tombol Back -->
    <a href="/dashboard" style="
        display:inline-block;
        margin-bottom:20px;
        text-decoration:none;
        background:#2c3e50;
        color:white;
        padding:8px 15px;
        border-radius:6px;
    ">
        ← Kembali ke Dashboard
    </a>

    <!-- CARD -->
    <div style="
        background:white;
        padding:25px;
        border-radius:12px;
        box-shadow:0 4px 12px rgba(0,0,0,0.1);
    ">

        <h1 style="margin-bottom:15px;">Absensi Karyawan</h1>

        <!-- FORM -->
        <form action="/attendance/masuk" method="POST" style="margin-bottom:20px;">
            @csrf
            <input type="text" name="nama" placeholder="Masukkan Nama" style="
                padding:8px;
                border-radius:6px;
                border:1px solid #ccc;
                margin-right:10px;
            ">
            <button type="submit" style="
                background:#2c7be5;
                color:white;
                padding:8px 15px;
                border:none;
                border-radius:6px;
            ">
                Absen Masuk
            </button>
        </form>

        <!-- TABEL -->
        <table style="
            width:100%;
            border-collapse:collapse;
            border-radius:10px;
            overflow:hidden;
        ">
            <thead>
                <tr>
                    <th style="padding:10px; background:#2c3e50; color:white;">Nama</th>
                    <th style="background:#2c3e50; color:white;">Tanggal</th>
                    <th style="background:#2c3e50; color:white;">Masuk</th>
                    <th style="background:#2c3e50; color:white;">Pulang</th>
                    <th style="background:#2c3e50; color:white;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $d)
                <tr style="text-align:center; border-top:1px solid #ddd;">
                    <td style="padding:10px;">{{ $d->nama }}</td>
                    <td>{{ $d->tanggal }}</td>
                    <td>{{ $d->jam_masuk }}</td>
                    <td>{{ $d->jam_pulang ?? '-' }}</td>
                    <td>
                        @if(!$d->jam_pulang)
                            <a href="/attendance/pulang/{{ $d->id }}">
                                <button style="
                                    background:#28a745;
                                    color:white;
                                    border:none;
                                    padding:5px 10px;
                                    border-radius:5px;
                                ">
                                    Pulang
                                </button>
                            </a>
                        @else
                            <span style="color:gray;">Sudah Pulang</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection