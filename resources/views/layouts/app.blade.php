<!DOCTYPE html>
<html>
<head>
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
    </style>
</head>

<body>

<div class="navbar">
    <a href="/home">Home</a>
    <a href="/about">About</a>
    <a href="/product">Product</a>
    <a href="/contact">Contact</a>
    <a href="/dashboard" style="color: white; margin-right:10px;"
   onmouseover="this.style.opacity='0.7'"
   onmouseout="this.style.opacity='1'">
   Dashboard
</a>
    <a href="/attendance">Absensi</a>
</div>

<div class="container" style="max-width: 800px; margin: auto;">
    @yield('content')
</div>

</body>
</html>