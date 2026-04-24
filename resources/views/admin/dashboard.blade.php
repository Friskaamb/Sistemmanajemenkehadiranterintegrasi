@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-blue-900 leading-tight">Selamat Siang, Admin</h2>
    <p class="text-gray-400">Jumat, 24 April 2026</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center"><i class="fas fa-users"></i></div>
        <div>
            <p class="text-gray-400 text-[10px] font-bold uppercase">Total Karyawan</p>
            <h4 class="text-2xl font-bold">247</h4>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center"><i class="fas fa-user-check"></i></div>
        <div>
            <p class="text-gray-400 text-[10px] font-bold uppercase">Hadir Hari Ini</p>
            <h4 class="text-2xl font-bold text-emerald-600">234</h4>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center"><i class="fas fa-clock"></i></div>
        <div>
            <p class="text-gray-400 text-[10px] font-bold uppercase">Terlambat</p>
            <h4 class="text-2xl font-bold text-amber-600">8</h4>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center"><i class="fas fa-user-times"></i></div>
        <div>
            <p class="text-gray-400 text-[10px] font-bold uppercase">Tidak Hadir</p>
            <h4 class="text-2xl font-bold text-red-600">5</h4>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-blue-900 mb-6 flex items-center gap-2"><i class="fas fa-chart-line"></i> Persentase Kehadiran Mingguan</h3>
        <canvas id="weeklyChart" height="200"></canvas>
    </div>
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-blue-900 mb-6 flex items-center gap-2"><i class="fas fa-exclamation-triangle"></i> Top Terlambat Bulan Ini</h3>
        <div class="flex items-center">
            <div class="w-1/2">
                <canvas id="lateChart"></canvas>
            </div>
            <div class="w-1/2 pl-8 space-y-3">
                <div class="flex items-center justify-between text-sm"><span class="text-gray-500"><i class="fas fa-circle text-red-500 mr-2"></i> David Kim</span> <span class="font-bold">8x</span></div>
                <div class="flex items-center justify-between text-sm"><span class="text-gray-500"><i class="fas fa-circle text-amber-500 mr-2"></i> Michael Chen</span> <span class="font-bold">6x</span></div>
                <div class="flex items-center justify-between text-sm"><span class="text-gray-500"><i class="fas fa-circle text-orange-400 mr-2"></i> Sarah Johnson</span> <span class="font-bold">4x</span></div>
                <div class="flex items-center justify-between text-sm text-gray-400 italic"><span>Lainnya</span> <span>12x</span></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
    <h3 class="font-bold text-gray-800 mb-2 leading-none">Log Kehadiran Hari Ini</h3>
    <p class="text-xs text-gray-400 mb-6 italic">Daftar kehadiran seluruh karyawan</p>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-gray-400 border-b uppercase text-[10px] font-bold">
                    <th class="pb-4">NIK</th>
                    <th class="pb-4">Nama</th>
                    <th class="pb-4">Departemen</th>
                    <th class="pb-4">Jam Masuk</th>
                    <th class="pb-4">Jam Pulang</th>
                    <th class="pb-4">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-4 font-mono text-xs">EMP-2024-001</td>
                    <td class="flex items-center gap-3"><div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-[10px] font-bold">SJ</div> Sarah Johnson</td>
                    <td>Engineering</td>
                    <td class="font-bold">08:45</td>
                    <td class="font-bold">17:30</td>
                    <td><span class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full text-[10px] font-bold">Hadir</span></td>
                </tr>
                </tbody>
        </table>
    </div>
</div>

<script>
    // Weekly Chart
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    new Chart(weeklyCtx, {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
            datasets: [{
                label: 'Kehadiran (%)',
                data: [95, 92, 98, 94, 90],
                backgroundColor: '#003366',
                borderRadius: 8
            }]
        },
        options: { scales: { y: { beginAtZero: true, max: 100 } } }
    });

    // Late Chart (Donut)
    const lateCtx = document.getElementById('lateChart').getContext('2d');
    new Chart(lateCtx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [8, 6, 4, 12],
                backgroundColor: ['#ef4444', '#f59e0b', '#fb923c', '#cbd5e1'],
                borderWidth: 0
            }]
        },
        options: { cutout: '70%' }
    });
</script>
@endsection