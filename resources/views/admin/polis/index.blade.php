<x-app-layout>
<div class="max-w-6xl mx-auto py-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Manajemen Poli</h2>

        <a href="{{ route('admin.polis.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded">
           + Tambah Poli
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Nama Poli</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($polis as $poli)
                <tr class="border-t">
                    <td class="p-3">{{ $poli->name }}</td>
                    <td class="p-3">{{ $poli->description }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('admin.polis.edit', $poli->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                           Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.polis.destroy', $poli->id) }}">
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

</div>
</x-app-layout>