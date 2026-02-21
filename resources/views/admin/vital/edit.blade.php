<x-app-layout>
<div class="max-w-6xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-6">
    Pemeriksaan Awal - {{ $patient->name }}
</h2>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-2 gap-8">

<!-- FORM VITAL -->
<div class="bg-white p-6 rounded shadow">
<h3 class="font-semibold mb-4">Isi Vital Sign</h3>

<form method="POST"
      action="{{ route('admin.vital.update', $appointment->id) }}">
@csrf

<div class="mb-3">
<label>Tekanan Darah</label>
<input type="text"
       name="blood_pressure"
       value="{{ $record->blood_pressure ?? '' }}"
       placeholder="120/80"
       class="w-full border p-2 rounded">
</div>

<div class="mb-3">
<label>Berat Badan (kg)</label>
<input type="number"
       step="0.1"
       name="weight"
       value="{{ $record->weight ?? '' }}"
       class="w-full border p-2 rounded">
</div>

<div class="mb-3">
<label>Tinggi Badan (cm)</label>
<input type="number"
       step="0.1"
       name="height"
       value="{{ $record->height ?? '' }}"
       class="w-full border p-2 rounded">
</div>

<div class="mb-3">
<label>Suhu (°C)</label>
<input type="number"
       step="0.1"
       name="temperature"
       value="{{ $record->temperature ?? '' }}"
       class="w-full border p-2 rounded">
</div>

<div class="mb-3">
<label>Keluhan Awal</label>
<textarea name="initial_complaint"
          class="w-full border p-2 rounded">{{ $record->initial_complaint ?? '' }}</textarea>
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Simpan
</button>

</form>
</div>

<!-- RIWAYAT -->
<div class="bg-white p-6 rounded shadow">
<h3 class="font-semibold mb-4">Riwayat Vital Terakhir</h3>

<table class="w-full text-sm">
<thead>
<tr class="bg-gray-100">
    <th class="p-2 text-left">Tanggal</th>
    <th class="p-2">TD</th>
    <th class="p-2">BB</th>
    <th class="p-2">TB</th>
    <th class="p-2">Suhu</th>
</tr>
</thead>
<tbody>
@foreach($previousVitals as $vital)
<tr class="border-t">
    <td class="p-2">
        {{ $vital->created_at->format('d-m-Y') }}
    </td>
    <td class="p-2 text-center">
        {{ $vital->blood_pressure ?? '-' }}
    </td>
    <td class="p-2 text-center">
        {{ $vital->weight ?? '-' }}
    </td>
    <td class="p-2 text-center">
        {{ $vital->height ?? '-' }}
    </td>
    <td class="p-2 text-center">
        {{ $vital->temperature ?? '-' }}
    </td>
</tr>
@endforeach
</tbody>
</table>

</div>

</div>

</div>
</x-app-layout>