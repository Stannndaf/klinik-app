<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-6">Data Pasien</h2>

<a href="{{ route('admin.patients.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
   + Tambah Pasien
</a>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">Kode</th>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Tipe</th>
            <th class="p-3 text-left">Telepon</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patients as $patient)
        <tr class="border-t">
            <td class="p-3 font-semibold">{{ $patient->patient_code }}</td>
            <td class="p-3">{{ $patient->name }}</td>
            <td class="p-3 uppercase">{{ $patient->patient_type }}</td>
            <td class="p-3">{{ $patient->phone }}</td>
            <td class="p-3 text-center">
                <a href="{{ route('admin.patients.edit', $patient->id) }}"
                   class="text-blue-600 font-medium">
                   Edit
                </a>

                <form action="{{ route('admin.patients.destroy', $patient->id) }}"
                      method="POST"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 ml-3 font-medium">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $patients->links() }}
</div>

</div>
</x-app-layout>