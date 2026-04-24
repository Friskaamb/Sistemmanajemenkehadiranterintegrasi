@extends('layouts.app')

@section('content')
<div class="bg-blue-600 rounded-2xl p-8 text-white flex justify-between items-center mb-8 shadow-lg shadow-blue-200">
    <div>
        <h2 class="text-3xl font-bold italic">Selamat Siang, Budi</h2>
        <p class="opacity-80">Jumat, 24 April 2026</p>
    </div>
    <button class="bg-white text-blue-600 px-6 py-3 rounded-xl font-bold shadow-sm hover:bg-gray-100 flex items-center gap-2">
        <i class="fas fa-download"></i> Download Slip Kehadiran
    </button>
</div>

<div class="grid md:grid-cols-2 gap-8 mb-8 text-center sm:text-left">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <div class="w-12 h-12 bg-green-50 text-green-500 rounded-xl flex items-center justify-center mb-4"><i class="far fa-clock text-2xl"></i></div>
        <h3 class="text-2xl font-bold text-gray-800 leading-none mb-2">Absen Masuk</h3>
        <p class="text-gray-400 mb-6 italic">Catat waktu kedatangan Anda hari ini</p>
        <button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-4 rounded-2xl font-bold text-lg transition shadow-lg shadow-emerald-100">
            Absen Masuk Sekarang
        </button>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center mb-4"><i class="far fa-clock text-2xl"></i></div>
        <h3 class="text-2xl font-bold text-gray-800 leading-none mb-2">Absen Pulang</h3>
        <p class="text-gray-400 mb-6 italic">Catat waktu kepulangan Anda hari ini</p>
        <button disabled class="w-full bg-gray-200 text-gray-400 py-4 rounded-2xl font-bold text-lg cursor-not-allowed">
            Absen Pulang Sekarang
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm leading-tight">
        <p class="text-gray-400 text-sm font-medium mb-2">Kehadiran Bulan Ini</p>
        <h4 class="text-4xl font-bold text-gray-800">18 Hari</h4>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm leading-tight">
        <p class="text-gray-400 text-sm font-medium mb-2">Sisa Cuti</p>
        <h4 class="text-4xl font-bold text-gray-800">8 Hari</h4>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm leading-tight">
        <p class="text-gray-400 text-sm font-medium mb-2">Keterlambatan</p>
        <h4 class="text-4xl font-bold text-gray-800">2 Kali</h4>
    </div>
</div>
@endsection