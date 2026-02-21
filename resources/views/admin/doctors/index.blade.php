<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Manajemen Dokter</h2>

    <a href="{{ route('admin.doctors.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded shadow">
       + Tambah Dokter
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
    {{ session('success') }}
</div>
@endif

<table class="w-full bg-white shadow rounded overflow-hidden">
<thead class="bg-gray-100">
<tr>
    <th class="p-3 text-left">Nama</th>
    <th class="p-3 text-left">Poli</th>
    <th class="p-3 text-left">Spesialisasi</th>
    <th class="p-3 text-left">Status</th>
    <th class="p-3 text-center">Aksi</th>
</tr>
</thead>
<tbody>

@forelse($doctors as $doctor)
<tr class="border-t">
    <td class="p-3 font-semibold">{{ $doctor->name }}</td>
    <td class="p-3">{{ $doctor->poli->name ?? '-' }}</td>
    <td class="p-3">{{ $doctor->specialization ?? '-' }}</td>

    <td class="p-3">
        @if($doctor->is_active)
            <span class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                Aktif
            </span>
        @else
            <span class="bg-gray-500 text-white px-2 py-1 rounded text-xs">
                Nonaktif
            </span>
        @endif
    </td>

    <td class="p-3 text-center flex justify-center gap-2">
        <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
           class="bg-yellow-500 text-white px-3 py-1 rounded">
           Edit
        </a>

        <form method="POST"
              action="{{ route('admin.doctors.destroy', $doctor->id) }}">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 text-white px-3 py-1 rounded">
                Hapus
            </button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="p-6 text-center text-gray-500">
        Belum ada dokter.
    </td>
</tr>
@endforelse

</tbody>
</table>

</div>
</x-app-layout>