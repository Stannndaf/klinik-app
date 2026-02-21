<x-app-layout>
<div class="max-w-xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-6">Tambah Poli</h2>

<form method="POST" action="{{ route('admin.polis.store') }}">
@csrf

<div class="mb-4">
    <label class="block mb-2">Nama Poli</label>
    <input type="text" name="name"
        class="w-full border rounded p-2" required>
</div>

<div class="mb-4">
    <label class="block mb-2">Deskripsi</label>
    <textarea name="description"
        class="w-full border rounded p-2"></textarea>
</div>

<button class="bg-indigo-600 text-white px-4 py-2 rounded">
    Simpan
</button>

</form>

</div>
</x-app-layout>