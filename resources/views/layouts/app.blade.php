<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kehadiran PT.DFL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Absensi App</title>

    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f4f6f9;
        }

        .navbar {
            background: #2c3e50;
            padding: 15px;
        }

        .navbar a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #3498db;
            color: white;
        }

        td, th {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        input {
            padding: 8px;
            width: 100%;
            margin-bottom: 10px;
        }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-16">
            <div class="flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-lg text-white"><i class="fas fa-home"></i></div>
                <div>
                    <h1 class="font-bold text-blue-900 leading-none">PT.DFL</h1>
                    <p class="text-xs text-gray-500">Portal Karyawan</p>
                </div>
            </div>
            
            <div class="hidden md:flex space-x-8 text-gray-600 font-medium">
                <a href="/karyawan/dashboard" class="{{ request()->is('karyawan/dashboard') ? 'text-blue-600 border-b-2 border-blue-600 pb-5' : 'hover:text-blue-600 transition' }}">Beranda</a>
                <a href="/karyawan/riwayat" class="{{ request()->is('karyawan/riwayat') ? 'text-blue-600 border-b-2 border-blue-600 pb-5' : 'hover:text-blue-600 transition' }}">Riwayat</a>
                <a href="/karyawan/izin" class="{{ request()->is('karyawan/izin') ? 'text-blue-600 border-b-2 border-blue-600 pb-5' : 'hover:text-blue-600 transition' }}">Izin/Cuti</a>
                <a href="/karyawan/profil" class="{{ request()->is('karyawan/profil') ? 'text-blue-600 border-b-2 border-blue-600 pb-5' : 'hover:text-blue-600 transition' }}">Profil</a>
            </div>

            <div class="flex items-center gap-3 border-l pl-6">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-800">Budi Santoso</p>
                    <p class="text-[10px] text-gray-400">EMP-2024-001</p>
                </div>
                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold">BS</div>
                <a href="/logout" class="text-gray-400 hover:text-red-500"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>
<body>

<div class="navbar">
    <a href="/home">Home</a>
    <a href="/about">About</a>
    <a href="/product">Product</a>
    <a href="/contact">Contact</a>
    <a href="/dashboard">Dashboard</a>
    <a href="/attendance">Absensi</a>

    @auth
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a>
    @endauth
</div>

<div class="container" style="max-width: 800px; margin: auto;">
    @yield('content')
</div>

    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>
</body>
</html>