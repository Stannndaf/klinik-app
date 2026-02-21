<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-6">Dashboard Antrian</h2>

{{-- ================= ANTRIAN ================= --}}
<div class="grid grid-cols-4 gap-6">

@foreach($appointments as $item)

@php
    $color = match($item->status) {
        'called' => 'bg-blue-600',
        'waiting' => 'bg-green-600',
        'booked' => 'bg-yellow-500',
        default => 'bg-gray-500'
    };

    $label = match($item->status) {
        'called' => 'SEDANG DIPANGGIL',
        'waiting' => 'SEDANG MENUNGGU',
        'booked' => 'BELUM CHECK-IN',
        default => strtoupper($item->status)
    };
@endphp

<div class="{{ $color }} text-white p-6 rounded shadow text-center">

    {{-- NOMOR ANTRIAN --}}
    <div class="text-4xl font-bold mb-2">
        No {{ $item->queue_number ?? '-' }}
    </div>

    {{-- TIPE PASIEN --}}
    <div class="text-xs font-semibold mb-2">
        {{ strtoupper($item->insurance_type ?? 'UMUM') }}
    </div>

    {{-- STATUS --}}
    <div class="text-sm mb-3">
        {{ $label }}
    </div>

    {{-- ================= WAITING ================= --}}
    @if($item->status == 'waiting' && !$hasCalled)
        <form method="POST"
              action="{{ route('admin.appointments.call', $item->id) }}">
            @csrf
            <button class="bg-white text-black px-3 py-1 rounded">
                Panggil
            </button>
        </form>
    @endif

    {{-- ================= CALLED ================= --}}
    @if($item->status == 'called')

    <div class="flex flex-col items-center gap-2">

        {{-- Tombol Selesai --}}
        <form method="POST"
              action="{{ route('admin.appointments.done', $item->id) }}">
            @csrf
            <button class="bg-white text-black px-3 py-1 rounded">
                Selesai
            </button>
        </form>

        {{-- Tombol Suara --}}
        <button onclick="playVoice({{ $item->queue_number }})"
            class="bg-yellow-400 text-black px-3 py-1 rounded">
            🔊 Panggil
        </button>

    </div>
    @endif

</div>

@endforeach

</div>

{{-- ================= LINK MENU ================= --}}
<div class="mt-10 text-center space-x-3">

    <a href="{{ route('admin.history') }}"
       class="bg-gray-800 text-white px-6 py-2 rounded">
       Lihat Riwayat
    </a>

    <a href="{{ route('admin.slots.index') }}"
       class="bg-blue-700 text-white px-6 py-2 rounded">
       Kelola Slot Praktek
    </a>

</div>

</div>

{{-- ================= SCRIPT ================= --}}
<script>
function playVoice(number) {
    const message = new SpeechSynthesisUtterance(
        "Nomor antrian " + number + " silakan ke ruang pemeriksaan"
    );

    message.lang = 'id-ID';
    message.rate = 1;
    message.pitch = 1;

    speechSynthesis.cancel(); // supaya tidak tumpuk
    speechSynthesis.speak(message);
}
</script>

</x-app-layout>