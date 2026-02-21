<x-app-layout>
<div class="max-w-3xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-6">Tambah Dokter</h2>

@if ($errors->any())
<div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
    <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.doctors.store') }}">
    @csrf

    <div class="mb-4">
        <label class="block font-semibold mb-1">Nama Dokter</label>
        <input type="text"
               name="name"
               class="w-full border rounded p-2"
               required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Poli</label>
        <select name="poli_id"
                class="w-full border rounded p-2"
                required>
            <option value="">-- Pilih Poli --</option>
            @foreach($polis as $poli)
                <option value="{{ $poli->id }}">
                    {{ $poli->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Spesialisasi (Opsional)</label>
        <input type="text"
               name="specialization"
               class="w-full border rounded p-2">
    </div>

    <div class="flex justify-between">
        <a href="{{ route('admin.doctors.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded">
           Kembali
        </a>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </div>

</form>

</div>
</x-app-layout>