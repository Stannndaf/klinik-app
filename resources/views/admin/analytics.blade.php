<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-8">Analytics Klinik</h2>

{{-- ================= HARI INI ================= --}}
    <h3 class="text-lg font-semibold mb-4">Statistik Hari Ini</h3>

<div class="grid grid-cols-5 gap-6 mb-10">

    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-3xl font-bold">{{ $totalToday }}</div>
        <div>Total Pasien</div>
    </div>

    <div class="bg-green-100 p-6 rounded shadow text-center">
        <div class="text-3xl font-bold">{{ $umumToday }}</div>
        <div>Umum</div>
    </div>

    <div class="bg-yellow-100 p-6 rounded shadow text-center">
        <div class="text-3xl font-bold">{{ $bpjsToday }}</div>
        <div>BPJS</div>
    </div>
    <div class="bg-red-100 p-6 rounded shadow text-center">
            <div class="text-3xl font-bold">{{ $cancelToday }}</div>
            <div>Cancel</div>
        </div>
    <div class="bg-blue-100 p-6 rounded shadow text-center">
        <div class="text-3xl font-bold">{{ $doneToday }}</div>
        <div>Selesai</div>
    </div>

    

</div>

{{-- ================= BULAN INI ================= --}}
<h3 class="text-lg font-semibold mb-4">Statistik Bulan Ini</h3>

<div class="grid grid-cols-5 gap-6">

    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-3xl font-bold">{{ $totalMonth }}</div>
        <div>Total Pasien</div>
    </div>

    <div class="bg-green-100 p-6 rounded shadow text-center">
        <div class="text-3xl font-bold">{{ $umumMonth }}</div>
        <div>Umum</div>
    </div>

    <div class="bg-yellow-100 p-6 rounded shadow text-center">
        <div class="text-3xl font-bold">{{ $bpjsMonth }}</div>
        <div>BPJS</div>
    </div>
    <div class="bg-red-100 p-6 rounded shadow text-center">
        <div class="text-3xl font-bold">{{ $cancelMonth }}</div>
        <div>Cancel</div>
    </div>
    <div class="bg-blue-100 p-6 rounded shadow text-center">
        <div class="text-3xl font-bold">{{ $doneMonth }}</div>
        <div>Selesai</div>
    </div>

    

</div>

</div>
</x-app-layout>