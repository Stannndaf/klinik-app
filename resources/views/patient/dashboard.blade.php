<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-4">
            Dashboard Pasien
        </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">

            <a href="{{ route('queue.create') }}"
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded shadow hover:bg-blue-700">
                Ambil Nomor Antrian
            </a>

            <a href="{{ route('profile.edit') }}"
               class="inline-block bg-gray-500 text-white px-6 py-3 rounded shadow hover:bg-gray-600">
                Edit Profil
            </a>

        </div>

    </div>
</x-app-layout>
