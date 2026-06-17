<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - PT.DFL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-lock text-2xl text-blue-600"></i>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-800">Lupa Kata Sandi?</h1>
            <p class="text-gray-500 mt-2 text-sm">
                Masukkan email Anda, kami akan mengirimkan link untuk reset password
            </p>
        </div>

        @if(session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                ✅ {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat Email
                </label>

                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-4 text-gray-400"></i>
                    <input
                        type="email"
                        name="email"
                        placeholder="nama@ptdfl.com"
                        value="{{ old('email') }}"
                        required
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                Kirim Link Reset
            </button>

            <!-- Kembali ke Login -->
            <p class="text-center text-sm">
                <a href="/login" class="text-blue-600 font-semibold hover:underline">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
                </a>
            </p>
        </form>

        <!-- Info Box -->
        <div class="mt-8 p-4 bg-blue-50 rounded-2xl border border-blue-100">
            <p class="text-xs text-blue-700">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Catatan:</strong> Link reset password akan berlaku selama 60 menit. Pastikan Anda mengecek email dengan baik termasuk folder spam.
            </p>
        </div>

    </div>

</body>
</html>
