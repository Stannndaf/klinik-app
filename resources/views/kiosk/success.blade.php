<!DOCTYPE html>
<html>
<head>
    <title>Antrian Berhasil</title>
    <meta http-equiv="refresh" content="5;url={{ route('kiosk.index') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-700 flex items-center justify-center h-screen text-white">

<div class="text-center">
    <h1 class="text-5xl font-bold mb-6">
        Nomor Antrian Anda
    </h1>

    <div class="text-8xl font-bold">
        {{ $queue }}
    </div>

    <p class="mt-6">
        Silakan menunggu panggilan
    </p>
</div>

</body>
</html>