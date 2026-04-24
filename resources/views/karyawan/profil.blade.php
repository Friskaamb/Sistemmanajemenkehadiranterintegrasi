@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="bg-blue-900 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
        <div class="z-10 w-32 h-32 bg-white rounded-full flex items-center justify-center text-blue-900 text-4xl font-bold border-4 border-blue-400">
            BS
        </div>
        <div class="z-10 text-center md:text-left">
            <h2 class="text-3xl font-bold">Budi Santoso</h2>
            <p class="text-blue-200 text-lg">Software Engineer</p>
            <p class="text-sm opacity-60">NIK: EMP-2024-001</p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-800 rounded-full opacity-20"></div>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-gray-400 text-sm font-medium mb-1">Departemen</p>
            <p class="text-gray-800 font-bold text-lg">Engineering</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-gray-400 text-sm font-medium mb-1">Tanggal Bergabung</p>
            <p class="text-gray-800 font-bold text-lg">1 Januari 2024</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-gray-400 text-sm font-medium mb-1"><i class="far fa-envelope mr-2"></i>Email</p>
            <p class="text-gray-800 font-bold text-lg">budi.santoso@ptdfl.com</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-gray-400 text-sm font-medium mb-1"><i class="fas fa-phone mr-2"></i>Telepon</p>
            <p class="text-gray-800 font-bold text-lg">+62 812 3456 7890</p>
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

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3 mb-6">
            <i class="fas fa-phone-alt text-blue-900"></i>
            <h3 class="text-xl font-bold text-gray-800">Informasi Kontak Emergency</h3>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Nama Kontak</p>
                <p class="text-gray-800 font-bold text-lg">Ani Santoso</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Hubungan</p>
                <p class="text-gray-800 font-bold text-lg">Istri</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Nomor Telepon</p>
                <p class="text-gray-800 font-bold text-lg">+62 813 9876 5432</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Alamat</p>
                <p class="text-gray-800 font-bold text-lg">Jl. Sudirman No. 123, Jakarta</p>
            </div>
        </div>
    </div>
</div>
@endsection