@extends('layouts.admin')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-bold text-blue-900 leading-tight">Rekap Absensi Karyawan</h2>
        <p class="text-gray-400">Pantau data kehadiran seluruh karyawan</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.rekap.excel', [
    'tanggal' => request('tanggal'),
    'status' => request('status')
]) }}"
class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-emerald-700 flex items-center gap-2 shadow-lg shadow-emerald-100">

    <i class="fas fa-file-excel"></i>
    Export Excel
</a>
    </div>
</div>

<form method="GET" action="{{ route('admin.rekap') }}">
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 grid md:grid-cols-4 gap-4">
    <div>
        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 tracking-widest">Rentang Tanggal</label>
        <input
    type="date"
    name="tanggal"
    value="{{ request('tanggal') }}"
    class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl">
    </div>
    <div>
        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 tracking-widest">
        Status Kehadiran
    </label>

        <select name="status" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900 text-sm">

    <option value="">Semua Status</option>

    <option value="Hadir"
        {{ request('status') == 'Hadir' ? 'selected' : '' }}>
        Hadir
    </option>

    <option value="Terlambat"
        {{ request('status') == 'Terlambat' ? 'selected' : '' }}>
        Terlambat
    </option>

    <option value="Izin"
        {{ request('status') == 'Izin' ? 'selected' : '' }}>
        Izin
    </option>

    <option value="Sakit"
        {{ request('status') == 'Sakit' ? 'selected' : '' }}>
        Sakit
    </option>

</select>
    </div>
    
    <div class="flex items-end">
        <button
    type="submit"
    class="w-full bg-blue-900 text-white p-3 rounded-xl font-bold hover:bg-black transition">
            <i class="fas fa-filter mr-2"></i> Terapkan Filter
        </button>
    </div>
</div>
</form>
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- =========================
            TABEL REKAP
    ========================== -->

    <div class="xl:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-400 text-[10px] font-bold uppercase tracking-widest border-b">
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Nama / NIK</th>
                    <th class="px-6 py-4">Masuk</th>
                    <th class="px-6 py-4">Pulang</th>
                    <th class="px-6 py-4">Total Jam</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Detail</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @foreach($data as $r)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium">{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800 leading-tight">{{ $r->user->name ?? '-' }}</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $r->user->nik ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4">{{ $r->jam_masuk ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $r->jam_pulang ?? '-' }}</td>

                    <td class="px-6 py-4">
                    {{ $r->total_jam ?? '-' }}
                    </td>

                   <td class="px-6 py-4">

                   <span class="{{ $r->status == 'Hadir'
                   ? 'bg-emerald-100 text-emerald-600'
                   : 'bg-orange-100 text-orange-600' }}
                   px-3 py-1 rounded-full text-[10px] font-bold">

{{ $r->status }}

</span>

</td>

                            {{ $r->status }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">

<button
type="button"
onclick="showDetail(
'{{ asset('uploads/absensi/'.$r->foto_masuk) }}',
'{{ $r->foto_pulang ? asset('uploads/absensi/'.$r->foto_pulang) : '' }}',
'{{ $r->latitude }}',
'{{ $r->longitude }}',
'{{ $r->jam_masuk }}',
'{{ $r->jam_pulang ?? '-' }}',
'{{ $r->total_jam ?? '-' }}',
'{{ $r->status }}',
'{{ $r->status_pulang ?? '-' }}'
)"
class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg">

<i class="fas fa-eye"></i>

</button>

</td>

</tr>


                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- =========================
        PANEL DETAIL
========================== -->

<div
id="detailPanel"
class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 h-fit sticky top-6">

<h2 class="text-2xl font-bold text-blue-900 mb-4">

Detail Absensi

</h2>

<div id="detailContent">

<div class="text-center py-16 text-gray-400">

<i class="fas fa-user-clock text-6xl mb-5"></i>

<p>

Klik tombol
<b>👁 Detail</b>

untuk melihat informasi absensi.

</p>

</div>

</div>

</div>

</div>

@endsection<script>

function showDetail(
fotoMasuk,
fotoPulang,
lat,
lng,
jamMasuk,
jamPulang,
totalJam,
statusMasuk,
statusPulang
){

document.getElementById("detailContent").innerHTML = `

<h3 class="font-bold text-lg mb-5">
Detail Absensi
</h3>

<div class="grid grid-cols-2 gap-4">

<div>
<h4 class="font-semibold mb-2">📸 Foto Masuk</h4>
<img src="${fotoMasuk}" class="rounded-xl border w-full">
</div>

<div>
<h4 class="font-semibold mb-2">📸 Foto Pulang</h4>

${fotoPulang != ''
? `<img src="${fotoPulang}" class="rounded-xl border w-full">`
: `<p class="text-gray-400">Belum Absen Pulang</p>`
}

</div>

</div>

<hr class="my-5">

<p><b>📍 Latitude</b><br>${lat}</p>

<p class="mt-2"><b>📍 Longitude</b><br>${lng}</p>

<p class="mt-4 text-green-600 font-bold">

✅ Dalam Radius Perusahaan

</p>

<hr class="my-5">

<p>Jam Masuk : ${jamMasuk}</p>

<p>Jam Pulang : ${jamPulang}</p>

<p>Total Jam : ${totalJam}</p>

<p>Status Masuk : ${statusMasuk}</p>

<p>Status Pulang : ${statusPulang}</p>

<a
href="https://www.google.com/maps?q=${lat},${lng}"
target="_blank"
class="mt-5 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg">

📍 Google Maps

</a>

`;

}
</script>