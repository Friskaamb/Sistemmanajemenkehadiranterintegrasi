@extends('layouts.app')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
    <h2 class="text-2xl font-bold text-blue-900 mb-1 leading-none">Riwayat Kehadiran</h2>
    <p class="text-gray-400 text-sm italic mb-8">5 hari terakhir</p>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
    <tr class="text-gray-400 uppercase text-xs font-bold border-b">

        <th class="pb-4">Tanggal</th>

        <th class="pb-4">Jam Masuk</th>

        <th class="pb-4">Jam Pulang</th>

        <th class="pb-4">Total Jam</th>

        <th class="pb-4">Status</th>

        <th class="pb-4 text-center">Detail</th>

    </tr>
</thead>
            <tbody class="text-gray-600 text-sm">
    @forelse($attendances as $attendance)
    <tr class="border-b">
        <td class="py-5 font-medium">
            {{ \Carbon\Carbon::parse($attendance->tanggal)->translatedFormat('d F Y') }}
        </td>

        <td>{{ $attendance->jam_masuk ?? '-' }}</td>

        <td>{{ $attendance->jam_pulang ?? '-' }}</td>

        <td>{{ $attendance->total_jam ?? '-' }}</td>

        <td>
            @if($attendance->status == 'Hadir')
                <span class="bg-green-100 text-green-600 px-4 py-1 rounded-full text-xs font-bold">
                    Hadir
                </span>
            @elseif($attendance->status == 'Terlambat')
                <span class="bg-orange-100 text-orange-600 px-4 py-1 rounded-full text-xs font-bold">
                    Terlambat
                </span>
            @else
                <span class="bg-gray-100 text-gray-600 px-4 py-1 rounded-full text-xs font-bold">
                    {{ $attendance->status }}
                </span>
            @endif
        </td>
        <td class="text-center">

<button
type="button"
onclick="toggleDetail({{ $attendance->id }})"
class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg">

👁 Detail

</button>

</td>
    </tr>
    <tr
id="detail{{ $attendance->id }}"
class="hidden bg-gray-50">

<td colspan="6">

<div class="p-6">

<h2 class="text-xl font-bold mb-6">

Detail Kehadiran

</h2>

<div class="grid md:grid-cols-2 gap-8">

<div>

<h3 class="font-bold mb-3">

📸 Foto Masuk

</h3>

@if($attendance->foto_masuk)

<img
src="{{ asset('uploads/absensi/'.$attendance->foto_masuk) }}"
class="rounded-xl border w-full">

@else

Belum ada foto

@endif

</div>

<div>

<h3 class="font-bold mb-3">

📸 Foto Pulang

</h3>

@if($attendance->foto_pulang)

<img
src="{{ asset('uploads/absensi/'.$attendance->foto_pulang) }}"
class="rounded-xl border w-full">

@else

Belum Absen Pulang

@endif

</div>

</div>

<hr class="my-6">

<div class="grid md:grid-cols-2 gap-8">

<div>

<h3 class="font-bold mb-4">

📍 Lokasi Absen

</h3>

<p>

Latitude :
<b>{{ $attendance->latitude }}</b>

</p>

<p>

Longitude :
<b>{{ $attendance->longitude }}</b>

</p>

<br>

<p class="text-green-600 font-bold">

✅ Dalam Radius Perusahaan

</p>

</div>

<div>

<h3 class="font-bold mb-4">

Informasi Kehadiran

</h3>

<p>Jam Masuk : {{ $attendance->jam_masuk }}</p>

<p>Jam Pulang : {{ $attendance->jam_pulang ?? '-' }}</p>

<p>Total Jam : {{ $attendance->total_jam ?? '-' }}</p>

<p>Status : {{ $attendance->status }}</p>

@if($attendance->latitude)

<a
href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}"
target="_blank"
class="inline-block mt-5 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">

📍 Lihat Lokasi di Google Maps

</a>

@endif

</div>

</div>

</div>

</td>

</tr>
    @empty
    <tr>
        <td colspan="6" class="text-center py-5 text-gray-400">
            Belum ada data absensi
        </td>
    </tr>
    @endforelse
</tbody>
        </table>
    </div>
</div>
<script>

function toggleDetail(id){

let detail=document.getElementById("detail"+id);

detail.classList.toggle("hidden");

}

</script>
@endsection