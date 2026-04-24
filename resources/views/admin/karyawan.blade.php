@extends('layouts.admin')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-bold text-blue-900 leading-tight">Manajemen Data Karyawan</h2>
        <p class="text-gray-400">Kelola informasi karyawan PT.DFL</p>
    </div>
    <div class="flex gap-3">
        <button class="bg-white border border-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 flex items-center gap-2 shadow-sm">
            <i class="fas fa-file-import"></i> Import Excel
        </button>
        <button class="bg-blue-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-black flex items-center gap-2 shadow-lg shadow-blue-100">
            <i class="fas fa-plus"></i> Tambah Karyawan Baru
        </button>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 grid md:grid-cols-3 gap-6">
    <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Cari Karyawan</label>
        <div class="relative">
            <i class="fas fa-search absolute left-4 top-4 text-gray-300"></i>
            <input type="text" placeholder="Cari nama atau NIK..." class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
        </div>
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Divisi</label>
        <select class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
            <option>Semua Divisi</option>
            <option>Engineering</option>
            <option>Marketing</option>
            <option>HR</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Status</label>
        <select class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Non-Aktif</option>
        </select>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-blue-900 text-white text-[10px] font-bold uppercase tracking-widest">
                    <th class="px-6 py-4 w-10"><input type="checkbox" class="rounded"></th>
                    <th class="px-6 py-4">Nama Karyawan</th>
                    <th class="px-6 py-4">NIK</th>
                    <th class="px-6 py-4">Divisi/Jabatan</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @php
                    $karyawans = [
                        ['nama' => 'Sarah Johnson', 'nik' => 'EMP-2024-001', 'divisi' => 'IT', 'jabatan' => 'Senior Developer', 'email' => 'sarah.j@ptdfl.com', 'status' => 'Aktif', 'initial' => 'SJ'],
                        ['nama' => 'Michael Chen', 'nik' => 'EMP-2024-002', 'divisi' => 'Marketing', 'jabatan' => 'Marketing Manager', 'email' => 'michael.c@ptdfl.com', 'status' => 'Aktif', 'initial' => 'MC'],
                        ['nama' => 'Robert Wilson', 'nik' => 'EMP-2024-006', 'divisi' => 'Marketing', 'jabatan' => 'Content Creator', 'email' => 'robert.w@ptdfl.com', 'status' => 'Non-Aktif', 'initial' => 'RW'],
                    ];
                @endphp

                @foreach($karyawans as $k)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-900 rounded-full flex items-center justify-center font-bold text-xs">{{ $k['initial'] }}</div>
                        <span class="font-bold text-gray-800">{{ $k['nama'] }}</span>
                    </td>
                    <td class="px-6 py-4 font-mono text-xs">{{ $k['nik'] }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800">{{ $k['divisi'] }}</p>
                        <p class="text-[10px] text-gray-400">{{ $k['jabatan'] }}</p>
                    </td>
                    <td class="px-6 py-4 text-xs">{{ $k['email'] }}</td>
                    <td class="px-6 py-4">
                        <span class="{{ $k['status'] == 'Aktif' ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-400' }} px-3 py-1 rounded-full text-[10px] font-bold">
                            {{ $k['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <button class="text-gray-400 hover:text-blue-600"><i class="far fa-eye"></i></button>
                        <button class="text-gray-400 hover:text-amber-500"><i class="far fa-edit"></i></button>
                        <button class="text-gray-400 hover:text-red-500"><i class="far fa-trash-alt"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-6 bg-gray-50 border-t flex justify-between items-center text-xs text-gray-400 font-medium">
        <p>Menampilkan 1-10 dari 150 Karyawan</p>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-white border rounded-lg hover:bg-gray-50">Previous</button>
            <button class="px-4 py-2 bg-blue-900 text-white border rounded-lg">Next</button>
        </div>
    </div>
</div>
@endsection