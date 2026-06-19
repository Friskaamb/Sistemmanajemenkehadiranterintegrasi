@extends('layouts.app')

@section('content')
<div class="grid md:grid-cols-3 gap-8">
    <div class="md:col-span-2 space-y-6">
        @if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-4">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl mb-4">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl mb-4">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-blue-900 mb-6">Ajukan Izin / Cuti</h2>
            
            <form action="/karyawan/izin/simpan" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Izin</label>
                        <select name="jenis_izin" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="Cuti">Cuti Tahunan</option>
                            <option value="Sakit">Sakit (Dengan Surat Dokter)</option>
                            <option value="Izin">Izin Keperluan Mendesak</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Lampiran</label>
                        <input type="file" name="lampiran" class="w-full p-2 bg-gray-50 border border-gray-200 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
                    <textarea name="alasan" rows="3" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none" placeholder="Tuliskan alasan detail..."></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                    Kirim Pengajuan
                </button>
            </form>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4">Status Pengajuan Terakhir</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
    <tr class="text-gray-400 border-b">
        <th class="pb-3">Jenis</th>
        <th class="pb-3">Tanggal</th>
        <th class="pb-3">Alasan</th>
        <th class="pb-3">Lampiran</th>
        <th class="pb-3">Status</th>
    </tr>
</thead>
                    <tbody class="text-gray-600">
    @forelse($izins as $izin)
    <tr class="border-b">
        <td class="py-4 font-medium">
    {{ $izin->jenis_izin }}
</td>

<td>
    {{ \Carbon\Carbon::parse($izin->tgl_mulai)->format('d M Y') }}
    -
    {{ \Carbon\Carbon::parse($izin->tgl_selesai)->format('d M Y') }}
</td>

<td>
    {{ $izin->alasan }}
</td>

<td>
    @if($izin->lampiran)
        <a href="{{ asset('uploads/'.$izin->lampiran) }}"
           target="_blank"
           class="text-blue-600 font-semibold">
           Lihat File
        </a>
    @else
        -
    @endif
</td>

<td>
    @if($izin->status == 'Pending')
        <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-bold">
            Pending
        </span>
    @elseif($izin->status == 'Disetujui')
        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">
            Disetujui
        </span>
    @else
        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
            Ditolak
        </span>
    @endif
</td>
    </tr>
    @empty
    <tr>
        <td colspan="3" class="text-center py-4">
            Belum ada pengajuan izin/cuti
        </td>
    </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center">
            <p class="text-gray-400 text-sm font-medium mb-1">Sisa Kuota Cuti Tahunan</p>
            <h4 class="text-5xl font-bold text-blue-900">
    {{ $sisaCuti }}
    <span class="text-lg text-gray-400">Hari</span>
</h4>
        </div>
        
        <div class="bg-blue-50 p-6 rounded-3xl border border-blue-100">
            <h4 class="font-bold text-blue-900 mb-2 text-sm"><i class="fas fa-info-circle mr-1"></i> Informasi</h4>
            <p class="text-xs text-blue-700 leading-relaxed">
                Pengajuan cuti minimal dilakukan 3 hari sebelum tanggal mulai. Untuk izin sakit, wajib melampirkan surat keterangan dokter yang sah.
            </p>
        </div>
    </div>
</div>
@endsection