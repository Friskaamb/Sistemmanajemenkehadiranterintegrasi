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

    <title>Login - Smart Absen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e9d9f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #fff;
            padding: 45px;
            border-radius: 16px;
            width: 500px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .logo {
            width: 180px;
            margin-bottom: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .title {
            font-size: 26px;
            font-weight: bold;
        }

        .subtitle {
            color: #555;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .btn {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: black;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn:hover {
            background: #333;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        input[type="checkbox"] {
            width: auto;
        }
        .row label {
           display: flex;
           align-items: center;
           gap: 5px;
        }
        a {
            text-decoration: none;
            color: blue;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<div class="card">

    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">

    <div class="title">SMART ABSEN</div>
    <div class="subtitle">Hadir Tepat, Kerja Hebat</div>

    <form method="POST" action="/login">
        @csrf

        <input type="email" name="email" placeholder="contoh@gmail.com" required>

        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <input type="password" name="password" placeholder="Password" required>

    <div class="row">
        <label class="remember">
            <input type="checkbox"> Ingat saya </label>
    <a href="#">Lupa Password?</a>
    </div>

        <button type="submit" class="btn">LOGIN</button>
    </form>
</div>

</body>
</html>