<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6">🩺 Dashboard Perawat (Ruang Vital)</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif


    {{-- ===================== --}}
    {{-- PASIEN DI RUANG VITAL --}}
    {{-- ===================== --}}
    <div class="bg-white shadow rounded p-6 mb-8">
        <h3 class="text-xl font-semibold mb-4 text-red-600">
            🔴 Sedang di Ruang Vital
        </h3>

        @if($currentVital)
            <div class="flex justify-between items-center border p-4 rounded">
                <div>
                    <p class="text-lg font-bold">
                        Antrian #{{ $currentVital->queue_number }}
                    </p>
                    <p>
                        {{ $currentVital->patient->name ?? 'Nama Tidak Ada' }}
                    </p>
                </div>

                <form method="POST"
                    action="{{ route('nurse.vital.done', $currentVital) }}">
                    @csrf
                    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Selesai Vital
                    </button>
                </form>
            </div>
        @else
            <p class="text-gray-500">Tidak ada pasien di ruang vital.</p>
        @endif
    </div>


    {{-- ===================== --}}
    {{-- PASIEN CHECKED IN --}}
    {{-- ===================== --}}
    <div class="bg-white shadow rounded p-6">
        <h3 class="text-xl font-semibold mb-4 text-blue-600">
            🟡 Siap Dipanggil ke Vital
        </h3>

        @if($checkedIn->count())
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">No</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Antrian</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checkedIn as $index => $appointment)
                        <tr>
                            <td class="p-2 border text-center">
                                {{ $index + 1 }}
                            </td>
                            <td class="p-2 border">
                                {{ $appointment->patient->name ?? '-' }}
                            </td>
                            <td class="p-2 border text-center">
                                #{{ $appointment->queue_number }}
                            </td>
                            <td class="p-2 border text-center">
                                <form method="POST"
                                    action="{{ route('nurse.call.vital', $appointment) }}">
                                    @csrf
                                    <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                        Panggil ke Vital
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Belum ada pasien check-in.</p>
        @endif
    </div>

</div>
</x-app-layout>