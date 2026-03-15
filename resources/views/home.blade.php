<!DOCTYPE html>
<html>
<head>
    <title>Home - Toko Sewa Baju</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            text-align: center;
            padding: 50px;
        }

        .container{
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            width: 60%;
            margin: auto;
        }

        h1{
            color: #2c3e50;
        }

        p{
            font-size: 18px;
        }

        .btn{
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover{
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">

<div>
Selamat Datang di Toko Sewa Baju Terbaik {{$nama}} <br>
Anda adalah seorang {{$pekerjaan}}
</div>

<p>
Kami menyediakan berbagai macam baju untuk berbagai acara seperti:
</p>

<ul style="list-style:none;">
<li>👗 Baju Pesta</li>
<li>🎓 Baju Wisuda</li>
<li>👘 Baju Adat</li>
</ul>
<p>
Temukan baju terbaik untuk acara spesial anda!
</p>

<a href="/contact" class="btn">Hubungi Kami</a>

</div>
</body>
</html>