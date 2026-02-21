<x-app-layout>
<div class="max-w-3xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-6">Tambah Pasien</h2>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $error)
            <li>- {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('nurse.patients.store') }}">
@csrf

<input name="name" placeholder="Nama Lengkap"
    class="w-full border p-2 mb-3 rounded" required>

<input name="email" type="email" placeholder="Email"
    class="w-full border p-2 mb-3 rounded" required>

<input name="nik" placeholder="NIK"
    class="w-full border p-2 mb-3 rounded" required>

<select name="patient_type" id="patient_type"
    class="w-full border p-2 mb-3 rounded" required>
    <option value="umum">Umum</option>
    <option value="bpjs">BPJS</option>
</select>

<input name="bpjs_number" id="bpjs_field"
    placeholder="Nomor BPJS"
    class="w-full border p-2 mb-3 rounded hidden">

<input name="birth_date" type="date"
    class="w-full border p-2 mb-3 rounded" required>

<select name="gender"
    class="w-full border p-2 mb-3 rounded" required>
    <option value="L">Laki-laki</option>
    <option value="P">Perempuan</option>
</select>

<input name="phone" placeholder="No HP"
    class="w-full border p-2 mb-3 rounded" required>

<textarea name="address"
    placeholder="Alamat"
    class="w-full border p-2 mb-3 rounded"
    required></textarea>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Simpan
</button>

</form>

</div>

<script>
document.getElementById('patient_type').addEventListener('change', function() {
    const bpjsField = document.getElementById('bpjs_field');
    if (this.value === 'bpjs') {
        bpjsField.classList.remove('hidden');
    } else {
        bpjsField.classList.add('hidden');
    }
});
</script>

</x-app-layout>