<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kehadiran PT.DFL</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-16">

            <div class="flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-lg text-white">
                    <i class="fas fa-home"></i>
                </div>

                <div>
                    <h1 class="font-bold text-blue-900 leading-none">
                        PT.DFL
                    </h1>

                    <p class="text-xs text-gray-500">
                        Portal Karyawan
                    </p>
                </div>
            </div>

            <div class="hidden md:flex space-x-8 text-gray-600 font-medium">
                <a href="/karyawan/dashboard"
                    class="{{ request()->is('karyawan/dashboard') ? 'text-blue-600 border-b-2 border-blue-600 pb-5' : 'hover:text-blue-600 transition' }}">
                    Beranda
                </a>

                <a href="/karyawan/riwayat"
                    class="{{ request()->is('karyawan/riwayat') ? 'text-blue-600 border-b-2 border-blue-600 pb-5' : 'hover:text-blue-600 transition' }}">
                    Riwayat
                </a>

                <a href="/karyawan/izin"
                    class="{{ request()->is('karyawan/izin') ? 'text-blue-600 border-b-2 border-blue-600 pb-5' : 'hover:text-blue-600 transition' }}">
                    Izin/Cuti
                </a>

                <a href="/karyawan/profil"
                    class="{{ request()->is('karyawan/profil') ? 'text-blue-600 border-b-2 border-blue-600 pb-5' : 'hover:text-blue-600 transition' }}">
                    Profil
                </a>
            </div>

            <div class="flex items-center gap-3 border-l pl-6">

                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-800">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-[10px] text-gray-400">
                        Karyawan
                    </p>
                </div>

                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                </div>

                <a href="{{ route('logout') }}"
                    class="text-gray-400 hover:text-red-500 transition">
                    <i class="fas fa-sign-out-alt text-xl"></i>
                </a>

            </div>

        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>

</body>
</html>