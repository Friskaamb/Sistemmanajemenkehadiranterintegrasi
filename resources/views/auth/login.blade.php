<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT.DFL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white w-full max-w-5xl h-[600px] rounded-3xl shadow-2xl overflow-hidden flex">
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
                <p class="italic text-blue-100 text-sm">"Membangun masa depan melalui inovasi dan dedikasi"</p>
            </div>

            <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80')] bg-cover"></div>
        </div>

        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
            <p class="text-gray-500 mb-8">Masuk ke sistem kehadiran PT.DFL</p>

            <form action="/login" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" placeholder="nama.anda@ptdfl.com" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-600 transition">
                </div>
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" placeholder="Masukkan kata sandi" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-600 transition">
                    <i class="far fa-eye absolute right-5 top-11 text-gray-400 cursor-pointer"></i>
                </div>

                <div class="space-y-3 text-center">
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                        Masuk Sebagai Karyawan
                    </button>
                    
                    <a href="/admin/dashboard" class="w-full bg-blue-900 text-white py-4 rounded-2xl font-bold text-lg hover:bg-black transition flex items-center justify-center">
                        Masuk Sebagai Admin
                    </a>
                </div>

                <div class="text-center pt-4">
                    <a href="#" class="text-sm text-blue-600 font-bold hover:underline">Lupa Kata Sandi?</a>
                </div>
                <p class="text-center text-sm text-gray-500 mt-4">
                    Karyawan baru? <a href="/register" class="text-blue-900 font-bold hover:underline">Daftar di sini</a>
                </p>
                <p class="text-center text-[10px] text-gray-400 mt-8">© 2026 PT. Digital Future Leaders</p>
            </form>
        </div>
    </div>
</body>
</html>