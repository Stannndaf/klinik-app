<x-app-layout>
<div class="max-w-3xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-6">Tambah Pasien</h2>

<form method="POST" action="{{ route('admin.patients.store') }}" class="bg-white p-6 rounded shadow">
@csrf

<div class="mb-4">
    <label class="block font-medium">Nama</label>
    <input type="text" name="name" class="w-full border p-2 rounded" required>
</div>

<div class="mb-4">
    <label class="block font-medium">Tipe Pasien</label>
    <select name="patient_type"
            id="patientType"
            class="w-full border p-2 rounded"
            onchange="toggleBPJS()">
        <option value="umum">Umum</option>
        <option value="bpjs">BPJS</option>
    </select>
</div>

<div class="mb-4 hidden" id="bpjsField">
    <label class="block font-medium">No BPJS</label>
    <input type="text"
           name="bpjs_number"
           class="w-full border p-2 rounded"
           id="bpjsInput">
</div>

<div class="mb-4">
    <label class="block font-medium">Telepon</label>
    <input type="text" name="phone" class="w-full border p-2 rounded">
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Simpan
</button>

<a href="{{ route('admin.patients.index') }}"
   class="ml-3 text-gray-600">
   Kembali
</a>

</form>

</div>

<script>
function toggleBPJS() {
    const type = document.getElementById('patientType').value;
    const field = document.getElementById('bpjsField');
    const input = document.getElementById('bpjsInput');

    if (type === 'bpjs') {
        field.classList.remove('hidden');
        input.setAttribute('required', 'required');
    } else {
        field.classList.add('hidden');
        input.removeAttribute('required');
        input.value = '';
    }
}
</script>

</x-app-layout>