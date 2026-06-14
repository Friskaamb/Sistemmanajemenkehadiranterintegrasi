@extends('layouts.app')

@section('content')

{{-- ALERT SUCCESS --}}
@if(session('success'))
<div class="mb-4 bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl">
    {{ session('success') }}
</div>
@endif

{{-- ALERT ERROR --}}
@if(session('error'))
<div class="mb-4 bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl">
    {{ session('error') }}
</div>
@endif

{{-- HEADER --}}
<div class="bg-blue-600 text-white p-8 rounded-3xl mb-8 shadow-lg">
    <h2 class="text-3xl font-bold">
        Selamat Datang, {{ Auth::user()->name }} 👋
    </h2>

    <p class="mt-2 text-blue-100">
        {{ now()->translatedFormat('d F Y') }}
    </p>
</div>

{{-- STATUS ABSENSI --}}
<div class="grid md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-3xl shadow p-6 border">
        <h4 class="text-gray-500 text-sm">
            Jam Masuk Hari Ini
        </h4>

        <p class="text-2xl font-bold text-green-600 mt-2">
            Belum Absen
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow p-6 border">
        <h4 class="text-gray-500 text-sm">
            Jam Pulang Hari Ini
        </h4>

        <p class="text-2xl font-bold text-blue-600 mt-2">
            Belum Absen
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow p-6 border">
        <h4 class="text-gray-500 text-sm">
            Status Kehadiran
        </h4>

        <p class="text-2xl font-bold text-orange-500 mt-2">
            Menunggu Absensi
        </p>
    </div>

</div>

{{-- ABSENSI --}}
<div class="grid md:grid-cols-2 gap-8">

    {{-- ABSEN MASUK --}}
    <div class="bg-white p-6 rounded-3xl shadow border">

        <h3 class="text-2xl font-bold mb-4">
            Absen Masuk
        </h3>

        <button
            onclick="bukaKamera('masuk')"
            aria-label="Absen Masuk"
            class="w-full bg-green-500 hover:bg-green-600 text-white py-4 rounded-xl font-semibold transition">

            📸 Absen Masuk

        </button>

    </div>

    {{-- ABSEN PULANG --}}
    <div class="bg-white p-6 rounded-3xl shadow border">

        <h3 class="text-2xl font-bold mb-4">
            Absen Pulang
        </h3>

        <button
            onclick="bukaKamera('pulang')"
            aria-label="Absen Pulang"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-4 rounded-xl font-semibold transition">

            📸 Absen Pulang

        </button>

    </div>

</div>


<div
    id="modalMasuk"
    class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">

    <div class="bg-white rounded-3xl w-full max-w-lg p-6 relative">

        <button
            onclick="tutupKamera('masuk')"
            class="absolute top-4 right-5 text-3xl text-gray-500 hover:text-red-500">

            &times;

        </button>

        <h3 class="text-xl font-bold mb-4">
            Foto Absen Masuk
        </h3>

        <video
            id="videoMasuk"
            autoplay
            playsinline
            class="w-full rounded-xl border">
        </video>

        <canvas id="canvasMasuk" class="hidden"></canvas>

        <button
            onclick="ambilFoto('masuk')"
            class="w-full mt-4 bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl">

            Ambil Foto

        </button>

    </div>

</div>


<div
    id="modalPulang"
    class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">

    <div class="bg-white rounded-3xl w-full max-w-lg p-6 relative">

        <button
            onclick="tutupKamera('pulang')"
            class="absolute top-4 right-5 text-3xl text-gray-500 hover:text-red-500">

            &times;

        </button>

        <h3 class="text-xl font-bold mb-4">
            Foto Absen Pulang
        </h3>

        <video
            id="videoPulang"
            autoplay
            playsinline
            class="w-full rounded-xl border">
        </video>

        <canvas id="canvasPulang" class="hidden"></canvas>

        <button
            onclick="ambilFoto('pulang')"
            class="w-full mt-4 bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-xl">

            Ambil Foto

        </button>

    </div>

</div>

<script>

let streamMasuk = null;
let streamPulang = null;

/*
|--------------------------------------------------------------------------
| BUKA KAMERA
|--------------------------------------------------------------------------
*/

async function bukaKamera(jenis)
{
    const modal =
        document.getElementById(
            jenis === 'masuk'
                ? 'modalMasuk'
                : 'modalPulang'
        );

    const video =
        document.getElementById(
            jenis === 'masuk'
                ? 'videoMasuk'
                : 'videoPulang'
        );

    modal.classList.remove('hidden');

    try
    {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: true
        });

        video.srcObject = stream;

        if(jenis === 'masuk')
        {
            streamMasuk = stream;
        }
        else
        {
            streamPulang = stream;
        }
    }
    catch(error)
    {
        alert('Kamera tidak dapat diakses.');

        console.error(error);

        modal.classList.add('hidden');
    }
}

/*
|--------------------------------------------------------------------------
| TUTUP KAMERA
|--------------------------------------------------------------------------
*/

function tutupKamera(jenis)
{
    const modal =
        document.getElementById(
            jenis === 'masuk'
                ? 'modalMasuk'
                : 'modalPulang'
        );

    modal.classList.add('hidden');

    const stream =
        jenis === 'masuk'
            ? streamMasuk
            : streamPulang;

    if(stream)
    {
        stream.getTracks().forEach(track => track.stop());
    }
}

/*
|--------------------------------------------------------------------------
| AMBIL FOTO
|--------------------------------------------------------------------------
*/

function ambilFoto(jenis)
{
    const video =
        document.getElementById(
            jenis === 'masuk'
                ? 'videoMasuk'
                : 'videoPulang'
        );

    const canvas =
        document.getElementById(
            jenis === 'masuk'
                ? 'canvasMasuk'
                : 'canvasPulang'
        );

    const context =
        canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    context.drawImage(
        video,
        0,
        0,
        canvas.width,
        canvas.height
    );

    const image =
        canvas.toDataURL(
            'image/png'
        );

    console.log(image);

    alert(
        jenis === 'masuk'
            ? 'Foto absen masuk berhasil diambil'
            : 'Foto absen pulang berhasil diambil'
    );

    tutupKamera(jenis);
}

/*
|--------------------------------------------------------------------------
| TUTUP MODAL SAAT KLIK LUAR
|--------------------------------------------------------------------------
*/

window.addEventListener('click', function(e)
{
    const modalMasuk =
        document.getElementById('modalMasuk');

    const modalPulang =
        document.getElementById('modalPulang');

    if(e.target === modalMasuk)
    {
        tutupKamera('masuk');
    }

    if(e.target === modalPulang)
    {
        tutupKamera('pulang');
    }
});

</script>

@endsection