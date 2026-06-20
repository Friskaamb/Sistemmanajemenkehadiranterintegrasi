@extends('layouts.admin')

@section('content')
@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl">
    {{ session('success') }}
</div>
@endif
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-bold text-blue-900 leading-tight">Manajemen Data Karyawan</h2>
        <p class="text-gray-400">Kelola informasi karyawan PT.DFL</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.karyawan.export') }}"
   class="bg-white border border-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 flex items-center gap-2 shadow-sm">

    <i class="fas fa-file-excel"></i>
    Export Excel

</a>
        <a href="{{ route('admin.karyawan.create') }}"
   class="bg-blue-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-black flex items-center gap-2 shadow-lg shadow-blue-100">
    <i class="fas fa-plus"></i>
    Tambah Karyawan Baru
</a> 
    </div>
</div>

<form method="GET" action="{{ route('admin.karyawan') }}">

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 grid md:grid-cols-3 gap-6">

    <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">
            Cari Karyawan
        </label>

        <div class="relative">
            <i class="fas fa-search absolute left-4 top-4 text-gray-300"></i>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau NIK..."
                class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">
            Divisi
        </label>

        <select
            name="division"
            class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">

            <option value="">Semua Divisi</option>

            @foreach($divisions as $divisi)
                <option value="{{ $divisi->id }}"
                    {{ request('division') == $divisi->id ? 'selected' : '' }}>
                    {{ $divisi->nama_divisi }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="flex items-end">
        <button
            type="submit"
            class="w-full bg-blue-900 text-white py-3 rounded-xl font-semibold">
            Cari
        </button>
    </div>

</div>

</form>
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
                

                @foreach($karyawans as $k)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-900 rounded-full flex items-center justify-center font-bold text-xs">{{ strtoupper(substr($k->name,0,1)) }}</div>
                        <span class="font-bold text-gray-800">{{ $k->name }}</span>
                    </td>
                    <td class="px-6 py-4 font-mono text-xs">{{ $k->nik }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800">{{ $k->division->nama_divisi ?? '-' }}</p>
                        <p class="text-gray-400 text-xs">{{ $k->role }}</p>
                    </td>
                    <td class="px-6 py-4 text-xs">{{ $k->email }}</td>
                    <td class="px-6 py-4">
                       <span class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full text-[10px] font-bold">Aktif</span>
                    </td>
                    <td class="px-6 py-4 text-center">

    <div class="flex justify-center gap-3">

        <a href="{{ route('admin.karyawan.edit', $k->id) }}"
        class="text-amber-500 hover:text-amber-700"> <i class="far fa-edit"></i></a>

        <form action="{{ route('admin.karyawan.destroy', $k->id) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="text-red-500 hover:text-red-700">
                <i class="far fa-trash-alt"></i>
            </button>

        </form>

    </div>

</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-6 bg-gray-50 border-t flex justify-between items-center text-xs text-gray-400 font-medium">
       <p>Total {{ $karyawans->total() }} Karyawan</p>
        <div>
    {{ $karyawans->links() }}
</div>
    </div>
</div>
@endsection