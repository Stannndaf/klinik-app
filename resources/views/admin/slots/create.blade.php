<x-app-layout>
<div class="max-w-xl mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6">Tambah Slot</h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if($errors->any())
        <div class="bg-red-500 text-white p-3 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.slots.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Dokter</label>
            <select name="doctor_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Dokter --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">
                        {{ $doctor->name }} ({{ $doctor->poli->name }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Tanggal</label>
            <input type="date" name="date"
                class="w-full border rounded p-2"
                value="{{ old('date') }}"
                required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Jam Mulai</label>
            <input type="time" name="start_time"
                class="w-full border rounded p-2"
                value="{{ old('start_time') }}"
                required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Jam Selesai</label>
            <input type="time" name="end_time"
                class="w-full border rounded p-2"
                value="{{ old('end_time') }}"
                required>
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-semibold">Kuota</label>
            <input type="number" name="capacity"
                class="w-full border rounded p-2"
                value="{{ old('capacity') }}"
                min="1"
                max="200"
                required>
        </div>

        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded w-full">
            Simpan Slot
        </button>

    </form>

</div>
</x-app-layout>