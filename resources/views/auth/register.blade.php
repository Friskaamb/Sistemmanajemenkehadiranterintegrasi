<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - PT.DFL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-12">

    <div class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl overflow-hidden flex">

        <!-- Kiri -->
        <div class="hidden md:flex w-1/2 bg-blue-900 p-12 flex-col justify-between text-white relative">

            <div class="z-10">
                <div class="bg-white/10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-th-large text-2xl text-white"></i>
                </div>

                <h1 class="text-5xl font-bold mb-2">PT. DFL</h1>
                <p class="text-xl text-blue-200">Digital Future Leaders</p>
                <p class="mt-4 opacity-60">Sistem Kehadiran Terintegrasi</p>
            </div>

            <div class="z-10 bg-white/10 p-6 rounded-2xl border border-white/20">
                <p class="italic text-blue-100 text-sm">
                    "Membangun masa depan melalui inovasi dan dedikasi"
                </p>
            </div>

            <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80')] bg-cover"></div>
        </div>

        <!-- Kanan -->
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center max-h-screen overflow-y-auto">

            <h2 class="text-4xl font-bold text-gray-800 mb-2">
                Daftar Akun Baru
            </h2>

            <p class="text-gray-500 mb-8">
                Buat akun untuk mengakses sistem kehadiran
            </p>

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg border border-red-300">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg border border-red-300">
                    <ul class="list-none">
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-check-circle mr-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Nama lengkap Anda"
                        value="{{ old('name') }}"
                        required
                        class="w-full p-3 bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="nama.anda@ptdfl.com"
                        value="{{ old('email') }}"
                        required
                        class="w-full p-3 bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        NIK (Nomor Identitas Karyawan)
                    </label>

                    <input
                        type="text"
                        name="nik"
                        placeholder="EMP-2024-001"
                        value="{{ old('nik') }}"
                        required
                        class="w-full p-3 bg-gray-50 border @error('nik') border-red-500 @else border-gray-200 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
                    @error('nik')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor Telepon
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        placeholder="08123456789"
                        value="{{ old('phone') }}"
                        class="w-full p-3 bg-gray-50 border @error('phone') border-red-500 @else border-gray-200 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kata Sandi
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                        class="w-full p-3 bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Konfirmasi Kata Sandi
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Ulangi kata sandi"
                        required
                        class="w-full p-3 bg-gray-50 border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-2xl font-bold text-lg hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                    Daftar
                </button>

                <p class="text-center text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="/login" class="text-blue-900 font-bold hover:underline">
                        Login di sini
                    </a>
                </p>
            </form>

        </div>

    </div>

</body>
</html>
