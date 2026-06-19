<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT.DFL - Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-slate-800">
    <nav class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-16">
            <div class="flex items-center gap-2">
                <div class="bg-blue-900 p-2 rounded-lg text-white"><i class="fas fa-th-large"></i></div>
                <div>
                    <h1 class="font-bold text-blue-900 leading-none text-lg">PT.DFL</h1>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">PORTAL HRD</p>
                </div>
            </div>
            
            <div class="hidden md:flex space-x-6 text-gray-500 font-semibold text-sm">
                <a href="/admin/dashboard" class="bg-blue-900 text-white px-4 py-2 rounded-xl flex items-center gap-2"><i class="fas fa-chart-pie"></i> Monitoring Kehadiran</a>
                <a href="/admin/karyawan" class="hover:text-blue-900 transition flex items-center gap-2 px-2"><i class="fas fa-users"></i> Data Karyawan</a>
                <a href="/admin/rekap" class="hover:text-blue-900 transition flex items-center gap-2 px-2"><i class="fas fa-file-alt"></i> Rekap Absensi</a>
                <a href="/admin/persetujuan" class="hover:text-blue-900 transition flex items-center gap-2 px-2"><i class="fas fa-check-square"></i> Persetujuan Cuti</a>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-gray-800">HR Manager</p>
                    <p class="text-[10px] text-gray-400">Human Resource</p>
                </div>
                <div class="w-10 h-10 bg-blue-900 rounded-full flex items-center justify-center text-white font-bold border-2 border-gray-100">AD</div>
                <button class="text-gray-400 hover:text-red-500 ml-2"><i class="fas fa-sign-out-alt"></i></button>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>
</body>
</html>