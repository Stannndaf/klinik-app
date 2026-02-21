<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">
            Ambil Nomor Antrian
        </h1>

        @if($doctors->isEmpty())
            <p class="text-red-500">
                Tidak ada dokter aktif saat ini.
            </p>
        @else
            <form method="POST" action="{{ route('queue.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block mb-2 font-semibold">
                        Pilih Dokter
                    </label>

                    <select name="doctor_id" class="border p-2 w-full rounded" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">
                                {{ $doctor->name }} ({{ $doctor->specialization }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Ambil Nomor
                </button>
            </form>
        @endif
    </div>
</x-app-layout>
