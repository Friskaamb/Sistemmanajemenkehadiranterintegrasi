<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - PT.DFL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-key text-2xl text-blue-600"></i>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-800">Reset Kata Sandi</h1>
            <p class="text-gray-500 mt-2 text-sm">
                Masukkan kata sandi baru Anda
            </p>
        </div>

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
        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ $email ?? old('email') }}"
                    required
                    class="w-full px-4 py-3 bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kata Sandi Baru
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required
                    class="w-full px-4 py-3 bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Kata Sandi
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi kata sandi baru"
                    required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                Reset Kata Sandi
            </button>

            <p class="text-center text-sm">
                <a href="/login" class="text-blue-600 font-semibold hover:underline">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
                </a>
            </p>
        </form>

    </div>

</body>
</html>
