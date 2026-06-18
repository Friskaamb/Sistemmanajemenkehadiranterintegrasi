@extends('layouts.app') 

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-blue-900">Permohonan Cuti & Izin</h2>
    <p class="text-gray-500">Permintaan yang menunggu persetujuan Anda</p>
</div>

@foreach($izins as $izin)
<div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-6 transition hover:shadow-md">
    <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
        
        <div class="flex items-center gap-4 w-full lg:w-1/4">
            <div class="w-14 h-14 bg-blue-100 text-blue-900 rounded-2xl flex items-center justify-center font-bold text-lg flex-shrink-0">
                {{ strtoupper(substr($izin->user->name,0,1)) }}
            </div>
            <div class="overflow-hidden text-left">
                <h4 class="text-lg font-bold text-gray-800 leading-tight truncate">{{ $izin->user->name }}</h4>
                <p class="text-xs text-gray-400 font-mono">{{ $izin->user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 w-full lg:w-2/4 text-left">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1 tracking-wider">Jenis</p>
                <p class="text-sm font-bold text-gray-700">{{ $izin->jenis_izin }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1 tracking-wider">Tanggal</p>
                <p class="text-sm font-bold text-gray-700">{{ $izin->tgl_mulai }} - {{ $izin->tgl_selesai }}</p>
            </div>
            <div class="hidden md:block">
                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1 tracking-wider">Alasan</p>
                <p class="text-sm text-gray-600 italic truncate" title="{{ $izin->alasan }}">"{{ $izin->alasan }}"</p>
            </div>
        </div>

        <div class="w-full lg:w-40 flex flex-col items-center lg:items-end gap-3">
            @if($izin->status == 'Pending')
    <span class="bg-amber-100 text-amber-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border border-amber-200">
        Pending
    </span>
@elseif($izin->status == 'Disetujui')
    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border border-green-200">
        Disetujui
    </span>
@else
    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border border-red-200">
        Ditolak
    </span>
@endif
            
            @if($izin->status == 'Pending')

<form action="{{ route('admin.persetujuan.update', $izin->id) }}" method="POST">
    @csrf

    <div class="flex flex-row lg:flex-col gap-2 w-full">

        <button
            type="submit"
            name="status"
            value="Disetujui"
            class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white py-2 rounded-xl font-bold text-sm transition shadow-sm border-b-4 border-emerald-700 active:border-0 active:mt-1">
            Setujui
        </button>

        <button
            type="submit"
            name="status"
            value="Ditolak"
            class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-xl font-bold text-sm transition shadow-sm border-b-4 border-red-700 active:border-0 active:mt-1">
            Tolak
        </button>

    </div>
</form>

@endif
        </div>
    </div>
</div>
@endforeach
@endsection