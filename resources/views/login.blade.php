<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
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
            background: white;
            padding: 40px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .title {
            font-size: 24px;
            font-weight: bold;
        }

        .subtitle {
            margin-bottom: 20px;
            color: gray;
        }

        input {
            width: 100%;
            padding: 10px;
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
            margin-top: 10px;
            font-size: 14px;
        }

        a {
            text-decoration: none;
            color: blue;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="card">
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
            <label><input type="checkbox"> Ingat saya</label>
            <a href="#">Lupa Password?</a>
        </div>

        <button type="submit" class="btn">LOGIN</button>
    </form>
</div>

</body>
</html>