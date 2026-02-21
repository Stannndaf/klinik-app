<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

<div class="flex justify-between mb-6">
    <h2 class="text-2xl font-bold">Manajemen Slot</h2>

    <a href="{{ route('admin.slots.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded">
       + Tambah Slot
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
    {{ session('success') }}
</div>
@endif

<table class="w-full bg-white shadow rounded">
<thead class="bg-gray-100">
<tr>
    <th class="p-3">Tanggal</th>
    <th class="p-3">Dokter</th>
    <th class="p-3">Poli</th>
    <th class="p-3">Jam</th>
    <th class="p-3">Kuota</th>
    <th class="p-3">Aksi</th>
</tr>
</thead>
<tbody>
@foreach($slots as $slot)
<tr class="border-t">
    <td class="p-3">{{ $slot->date }}</td>
    <td class="p-3">{{ $slot->doctor->name }}</td>
    <td class="p-3">{{ $slot->doctor->poli->name }}</td>
    <td class="p-3">{{ $slot->start_time }} - {{ $slot->end_time }}</td>
    <td class="p-3">{{ $slot->capacity }}</td>
    <td class="p-3 flex gap-2">
        <a href="{{ route('admin.slots.edit', $slot->id) }}"
           class="bg-yellow-500 text-white px-3 py-1 rounded">
           Edit
        </a>

        <form method="POST"
              action="{{ route('admin.slots.destroy', $slot->id) }}">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 text-white px-3 py-1 rounded">
                Hapus
            </button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>

</div>
</x-app-layout>