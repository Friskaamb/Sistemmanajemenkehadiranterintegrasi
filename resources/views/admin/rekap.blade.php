@extends('layouts.admin')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-bold text-blue-900 leading-tight">Rekap Absensi Karyawan</h2>
        <p class="text-gray-400">Pantau kehadiran dan validasi lokasi GPS</p>
    </div>
    <div class="flex gap-3">
        <button class="bg-white border border-gray-200 text-red-600 px-6 py-3 rounded-xl font-bold hover:bg-red-50 flex items-center gap-2 shadow-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
        </button>
        <button class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-emerald-700 flex items-center gap-2 shadow-lg shadow-emerald-100">
            <i class="fas fa-file-excel"></i> Export Excel
        </button>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 grid md:grid-cols-4 gap-4">
    <div>
        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 tracking-widest">Rentang Tanggal</label>
        <input type="date" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900 text-sm">
    </div>
    <div>
        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 tracking-widest">Status Kehadiran</label>
        <select class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900 text-sm">
            <option>Semua Status</option>
            <option>Hadir</option>
            <option>Terlambat</option>
            <option>Izin/Sakit</option>
        </select>
    </div>
    <div>
        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2 tracking-widest">Status GPS</label>
        <select class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900 text-sm">
            <option>Semua Lokasi</option>
            <option>GPS Verified</option>
            <option>Warning (Out of Range)</option>
        </select>
    </div>
    <div class="flex items-end">
        <button class="w-full bg-blue-900 text-white p-3 rounded-xl font-bold hover:bg-black transition">
            <i class="fas fa-filter mr-2"></i> Terapkan Filter
        </button>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-400 text-[10px] font-bold uppercase tracking-widest border-b">
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Nama / NIK</th>
                    <th class="px-6 py-4">Masuk</th>
                    <th class="px-6 py-4">Pulang</th>
                    <th class="px-6 py-4">Status GPS</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @php
                    $rekap = [
                        ['tgl' => '24 Apr 2026', 'nama' => 'Budi Santoso', 'nik' => 'EMP-001', 'in' => '08:00', 'out' => '17:05', 'gps' => 'Verified', 'status' => 'Hadir'],
                        ['tgl' => '24 Apr 2026', 'nama' => 'Sarah Johnson', 'nik' => 'EMP-002', 'in' => '08:45', 'out' => '17:30', 'gps' => 'Warning', 'status' => 'Terlambat'],
                        ['tgl' => '23 Apr 2026', 'nama' => 'Michael Chen', 'nik' => 'EMP-003', 'in' => '07:55', 'out' => '17:00', 'gps' => 'Verified', 'status' => 'Hadir'],
                    ];
                @endphp

                @foreach($rekap as $r)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium">{{ $r['tgl'] }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800 leading-tight">{{ $r['nama'] }}</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $r['nik'] }}</p>
                    </td>
                    <td class="px-6 py-4">{{ $r['in'] }}</td>
                    <td class="px-6 py-4">{{ $r['out'] }}</td>
                    <td class="px-6 py-4">
                        @if($r['gps'] == 'Verified')
                            <span class="flex items-center gap-1 text-emerald-600 font-bold text-[10px]">
                                <i class="fas fa-check-circle"></i> GPS VERIFIED
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-red-500 font-bold text-[10px]">
                                <i class="fas fa-exclamation-triangle"></i> WARNING (OUT)
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="{{ $r['status'] == 'Hadir' ? 'bg-emerald-100 text-emerald-600' : 'bg-orange-100 text-orange-600' }} px-3 py-1 rounded-full text-[10px] font-bold">
                            {{ $r['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-900 hover:underline font-bold text-xs">Detail Maps</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection