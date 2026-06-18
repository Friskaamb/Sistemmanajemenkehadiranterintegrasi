@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="mb-4 bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-4 bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="mb-4 bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="space-y-8">
    <div class="bg-blue-900 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
        <div class="z-10 w-32 h-32 bg-white rounded-full flex items-center justify-center text-blue-900 text-4xl font-bold border-4 border-blue-400">
            {{ strtoupper(substr($user->name,0,1)) }}
        </div>
        <div class="z-10 text-center md:text-left">
            <h2 class="text-3xl font-bold">{{ $user->name }}</h2>
            <p class="text-blue-200 text-lg">{{ ucfirst($user->role) }}</p>
            <p class="text-sm opacity-60">Email: {{ $user->email }}</p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-800 rounded-full opacity-20"></div>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-gray-400 text-sm font-medium mb-1">Divisi</p>
            <p class="text-gray-800 font-bold text-lg">{{ $user->division->nama_divisi ?? 'Belum diatur' }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-gray-400 text-sm font-medium mb-1">Tanggal Bergabung</p>
            <p class="text-gray-800 font-bold text-lg">{{ $user->created_at->format('d F Y') }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-gray-400 text-sm font-medium mb-1"><i class="far fa-envelope mr-2"></i>Email</p>
            <p class="text-gray-800 font-bold text-lg">{{ $user->email }}</p>
        </div>
    
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3 mb-6">
            <i class="fas fa-lock text-blue-900"></i>
            <h3 class="text-xl font-bold text-gray-800">Ubah Kata Sandi</h3>
        </div>
        <form action="/karyawan/profil/update" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Kata Sandi Lama</label>
                <input type="password" name="old_password" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kata Sandi Baru</label>
                    <input type="password" name="new_password" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="confirm_password" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-900 text-white py-4 rounded-2xl font-bold hover:bg-blue-800 transition">
                Update Kata Sandi
            </button>
        </form>
        </div>
        </div>
    </div>
</div>
@endsection