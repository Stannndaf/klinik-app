<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6">👨‍⚕️ Dashboard Dokter</h2>

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
    {{-- PASIEN SEDANG DIPANGGIL --}}
    {{-- ===================== --}}
    <div class="bg-white shadow rounded p-6 mb-8">
        <h3 class="text-xl font-semibold mb-4 text-red-600">
            🔴 Sedang Dipanggil
        </h3>

        @if($currentCalled)
            <div class="border p-6 rounded space-y-4">

                {{-- INFO PASIEN --}}
                <div>
                    <p class="text-lg font-bold">
                        Antrian #{{ $currentCalled->queue_number }}
                    </p>
                    <p>
                        {{ $currentCalled->patient->name ?? '-' }}
                    </p>
                </div>

                {{-- DATA VITAL --}}
                @if($currentCalled->vital)
                    <div class="bg-gray-100 p-4 rounded">
                        <h4 class="font-semibold mb-2">🩺 Data Vital</h4>
                        <p><strong>Tekanan Darah:</strong> {{ $currentCalled->vital->blood_pressure ?? '-' }}</p>
                        <p><strong>Suhu:</strong> {{ $currentCalled->vital->temperature ?? '-' }}</p>
                        <p><strong>Nadi:</strong> {{ $currentCalled->vital->pulse ?? '-' }}</p>
                        <p><strong>Catatan Perawat:</strong> {{ $currentCalled->vital->notes ?? '-' }}</p>
                    </div>
                @else
                    <div class="bg-yellow-100 text-yellow-700 p-3 rounded">
                        Data vital belum diisi oleh perawat.
                    </div>
                @endif

                {{-- FORM REKAM MEDIS --}}
                <form method="POST"
                    action="{{ route('doctor.done', $currentCalled) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="block font-semibold mb-1">
                            Rekam Medis / Diagnosa
                        </label>
                        <textarea name="medical_notes"
                            class="w-full border rounded px-3 py-2"
                            rows="4"
                            placeholder="Tulis diagnosa, tindakan, resep..."></textarea>
                    </div>

                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Selesai Pemeriksaan
                    </button>
                </form>

            </div>
        @else
            <p class="text-gray-500">Tidak ada pasien sedang dipanggil.</p>
        @endif
    </div>


    {{-- ===================== --}}
    {{-- WAITING LIST --}}
    {{-- ===================== --}}
    <div class="bg-white shadow rounded p-6">
        <h3 class="text-xl font-semibold mb-4 text-blue-600">
            🟡 Menunggu Pemeriksaan
        </h3>

        @if($waiting->count())
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
                    @foreach($waiting as $index => $appointment)
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
                                    action="{{ route('doctor.call', $appointment) }}">
                                    @csrf
                                    <button class="bg-blue-600 text-white px-3 py-1 rounded">
                                        Panggil
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Tidak ada pasien menunggu.</p>
        @endif
    </div>

</div>
</x-app-layout>