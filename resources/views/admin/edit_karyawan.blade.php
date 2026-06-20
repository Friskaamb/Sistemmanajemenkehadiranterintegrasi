@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-blue-900">
            Edit Data Karyawan
        </h2>

        <p class="text-gray-400">
            Perbarui informasi karyawan
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

        <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-5">

                <div>
                    <label class="font-semibold">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ $karyawan->name }}"
                        class="w-full border rounded-xl p-3 mt-2"
                        required>
                </div>

                <div>
                    <label class="font-semibold">
                        NIK
                    </label>

                    <input
                        type="text"
                        name="nik"
                        value="{{ $karyawan->nik }}"
                        class="w-full border rounded-xl p-3 mt-2"
                        required>
                </div>

                <div>
                    <label class="font-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ $karyawan->email }}"
                        class="w-full border rounded-xl p-3 mt-2"
                        required>
                </div>

                <div>
                    <label class="font-semibold">
                        Divisi
                    </label>

                    <select
                        name="division_id"
                        class="w-full border rounded-xl p-3 mt-2"
                        required>

                        @foreach($divisions as $divisi)

                        <option
                            value="{{ $divisi->id }}"
                            {{ $karyawan->division_id == $divisi->id ? 'selected' : '' }}>

                            {{ $divisi->nama_divisi }}

                        </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="mt-8 flex gap-3">

                <button
                    type="submit"
                    class="bg-blue-900 text-white px-6 py-3 rounded-xl hover:bg-black">

                    Simpan Perubahan

                </button>

                <a
                    href="{{ route('admin.karyawan') }}"
                    class="bg-gray-200 px-6 py-3 rounded-xl">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection