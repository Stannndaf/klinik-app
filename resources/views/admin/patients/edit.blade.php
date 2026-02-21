<x-app-layout>
<div class="max-w-3xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-6">Edit Pasien</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="{{ route('admin.patients.update', $patient->id) }}"
      class="bg-white p-6 rounded shadow">
@csrf
@method('PUT')

<div class="mb-4">
    <label class="block font-medium">Kode Pasien</label>
    <input type="text"
           value="{{ $patient->patient_code }}"
           class="w-full border p-2 rounded bg-gray-100"
           disabled>
</div>

<div class="mb-4">
    <label class="block font-medium">Nama</label>
    <input type="text"
           name="name"
           value="{{ $patient->name }}"
           class="w-full border p-2 rounded"
           required>
</div>

<div class="mb-4">
    <label class="block font-medium">Tipe Pasien</label>
    <select name="patient_type"
            class="w-full border p-2 rounded">
        <option value="umum"
            {{ $patient->patient_type == 'umum' ? 'selected' : '' }}>
            Umum
        </option>
        <option value="bpjs"
            {{ $patient->patient_type == 'bpjs' ? 'selected' : '' }}>
            BPJS
        </option>
    </select>
</div>

<div class="mb-4">
    <label class="block font-medium">No BPJS</label>
    <input type="text"
           name="bpjs_number"
           value="{{ $patient->bpjs_number }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-4">
    <label class="block font-medium">Telepon</label>
    <input type="text"
           name="phone"
           value="{{ $patient->phone }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-4">
    <label class="block font-medium">Alamat</label>
    <textarea name="address"
              class="w-full border p-2 rounded"
              rows="3">{{ $patient->address }}</textarea>
</div>

<div class="flex gap-3">
    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Update
    </button>

    <a href="{{ route('admin.patients.index') }}"
       class="bg-gray-300 px-4 py-2 rounded">
        Kembali
    </a>
</div>

</form>

</div>
</x-app-layout>