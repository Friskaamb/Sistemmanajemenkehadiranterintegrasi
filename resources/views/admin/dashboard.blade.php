@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-blue-900 leading-tight">
        Monitoring Kehadiran Karyawan
    </h2>
<p class="text-gray-400">
    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
</p>
</div>

<!-- Statistik -->

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
        <i class="fas fa-users"></i>
    </div>
    <div>
        <p class="text-gray-400 text-[10px] font-bold uppercase">Total Karyawan</p>
        <h4 class="text-2xl font-bold">{{ $totalKaryawan }}</h4>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center">
        <i class="fas fa-user-check"></i>
    </div>
    <div>
        <p class="text-gray-400 text-[10px] font-bold uppercase">Kehadiran Hari Ini</p>
        <h4 class="text-2xl font-bold text-emerald-600">{{ $hadirHariIni }}</h4>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center">
        <i class="fas fa-clock"></i>
    </div>
    <div>
        <p class="text-gray-400 text-[10px] font-bold uppercase">Karyawan Terlambat</p>
        <h4 class="text-2xl font-bold text-amber-600">{{ $terlambat }}</h4>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
        <i class="fas fa-user-times"></i>
    </div>
    <div>
        <p class="text-gray-400 text-[10px] font-bold uppercase">Belum Hadir</p>
        <h4 class="text-2xl font-bold text-red-600">{{ $tidakHadir }}</h4>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
        <i class="fas fa-calendar-check"></i>
    </div>
    <div>
        <p class="text-gray-400 text-[10px] font-bold uppercase">Cuti Pending</p>
        <h4 class="text-2xl font-bold text-purple-600">{{ $cutiPending }}</h4>
    </div>
</div>

</div>

<!-- Grafik -->

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 items-start">

    <!-- Grafik Divisi -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">

        <h3 class="font-bold text-blue-900 mb-6 flex items-center gap-2">
            <i class="fas fa-chart-bar"></i>
            Jumlah Karyawan per Divisi
        </h3>

        <div class="flex-1 h-72">
            <canvas id="divisionChart"></canvas>
        </div>

    </div>

    <!-- Card Ranking -->
<div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col">
        <div class="flex justify-between items-center mb-6">

    <div>
        <h3 class="font-bold text-red-600 text-lg">
            🚨 Top 5 Analisis Keterambatan Karyawan
        </h3>

        <p class="text-gray-400 text-xs leading-relaxed mt-2 mb-4">
    Data diperbarui secara otomatis berdasarkan riwayat absensi 30 hari terakhir.
</p>
    </div>

    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">
        30 Hari
    </span>

</div>
        @php
             $max = $topTerlambat->max('total');
        @endphp

        @forelse($topTerlambat as $index => $item)

    @php
        $medali = ['🥇','🥈','🥉','4️⃣','5️⃣'];

        $warna = [
            'bg-red-500',
            'bg-orange-500',
            'bg-yellow-500',
            'bg-blue-500',
            'bg-indigo-500'
        ];
    @endphp

    <div class="mb-5">

        <div class="flex justify-between items-center mb-2">

            <div class="font-semibold text-gray-700">
                {{ $medali[$index] }}
                {{ $item->nama }}
            </div>

            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
                {{ $item->total }} kali
            </span>

        </div>

        <div class="w-full bg-gray-200 rounded-full h-3">
    <div
        class="{{ $warna[$index] }} h-3 rounded-full"
        style="width: {{ $max > 0 ? ($item->total / $max) * 100 : 0 }}%;">
    </div>
</div>

    </div>

@empty

<div class="flex justify-center items-center h-56 text-gray-400">
    Belum ada data keterlambatan.
</div>

@endforelse

    </div>

</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
    <h3 class="font-bold text-gray-800 mb-2 leading-none">10 aktivitas absensi terakhir</h3>
    <p class="text-xs text-gray-400 mb-6 italic">Daftar kehadiran seluruh karyawan</p>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-gray-400 border-b uppercase text-[10px] font-bold">
                    <th class="pb-4">NIK</th>
                    <th class="pb-4">Nama</th>
                    <th class="pb-4">Divisi</th>
                    <th class="pb-4">Jam Masuk</th>
                    <th class="pb-4">Jam Pulang</th>
                    <th class="pb-4">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">

@forelse($absensiTerbaru as $absen)

<tr class="border-b hover:bg-gray-50 transition">

    <td class="py-4">{{ $absen->user->nik ?? '-' }}</td>

    <td>{{ $absen->nama }}</td>

    <td>{{ $absen->user->division->nama_divisi ?? '-' }}</td>

    <td>{{ $absen->jam_masuk }}</td>

    <td>{{ $absen->jam_pulang ?? '-' }}</td>

    <td>@if($absen->status == 'Hadir')
            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-[10px] font-bold">Hadir</span>
        @elseif($absen->status == 'Terlambat')
            <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-[10px] font-bold">Terlambat</span>
        @else
            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-[10px] font-bold">{{ $absen->status }}</span>
        @endif
    </td>

</tr>

@empty

<tr>
    <td colspan="6" class="text-center py-4">Belum ada data absensi</td>
</tr>

@endforelse

           </tbody>
        </table>
    </div>
</div>
<script>
    const divisionLabels = [
    @foreach($divisions as $divisi)
        "{{ $divisi->nama_divisi }}",
    @endforeach
];

const divisionData = [
    @foreach($divisions as $divisi)
        {{ $divisi->users_count }},
    @endforeach
];
    const ctx = document.getElementById('divisionChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: divisionLabels,
        datasets: [{
    label: 'Jumlah Karyawan',
    data: divisionData,
    backgroundColor: [
    '#1e40af',
    '#2563eb',
    '#3b82f6',
    '#60a5fa'
],
    borderRadius: 10
}]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        }
    },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

</script>
<p class="text-center text-xs text-gray-400 mt-6 mb-4">
    PT.DFL HRD Portal © 2026
</p>

@endsection