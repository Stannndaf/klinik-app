<!DOCTYPE html>
<html>
<head>
<title>Cetak Antrian</title>
@vite(['resources/css/app.css'])
</head>
<body class="flex items-center justify-center h-screen bg-white">

<div class="text-center">

<h1 class="text-5xl font-bold mb-4">
Nomor {{ $appointment->queue_number }}
</h1>

<p class="mb-2">
Poli: {{ $appointment->slot->doctor->poli->name ?? '-' }}
</p>

<p class="mb-2">
Dokter: {{ $appointment->slot->doctor->name ?? '-' }}
</p>

<p class="mb-4">
{{ now()->format('d-m-Y') }}
</p>

<div class="flex justify-center">
{!! QrCode::size(150)->generate(route('admin.vital.edit', $appointment->id)) !!}
</div>

<script>
window.print();
</script>

</div>

</body>
</html>