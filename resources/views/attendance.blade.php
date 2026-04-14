<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
</head>
<body>

<h1>Absensi Karyawan</h1>

<!-- FORM ABSEN MASUK -->
<form action="/attendance/masuk" method="POST">
    @csrf
    <input type="text" name="nama" placeholder="Masukkan Nama">
    <button type="submit">Absen Masuk</button>
</form>

<br>

<!-- TABEL DATA -->
<table border="1" cellpadding="10">
    <tr>
        <th>Nama</th>
        <th>Tanggal</th>
        <th>Masuk</th>
        <th>Pulang</th>
        <th>Aksi</th>
    </tr>

    @foreach($data as $d)
    <tr>
        <td>{{ $d->nama }}</td>
        <td>{{ $d->tanggal }}</td>
        <td>{{ $d->jam_masuk }}</td>
        <td>{{ $d->jam_pulang ?? '-' }}</td>
        <td>
            @if(!$d->jam_pulang)
                <a href="/attendance/pulang/{{ $d->id }}">
                    <button>Pulang</button>
                </a>
            @else
                Sudah Pulang
            @endif
        </td>
    </tr>
    @endforeach

</table>

</body>
</html>