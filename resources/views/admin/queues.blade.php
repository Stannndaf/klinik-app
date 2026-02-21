<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">
            Daftar Antrian Hari Ini
        </h1>

        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ← Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @forelse($queues as $queue)
            <div class="border p-4 mb-4 rounded shadow flex justify-between items-center">

                <div>
                    <p><strong>No:</strong> {{ $queue->queue_number }}</p>
                    <p><strong>Pasien:</strong> {{ $queue->user->name }}</p>
                    <p><strong>Dokter:</strong> {{ $queue->doctor->name }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($queue->status) }}</p>
                </div>

                <div class="space-x-2">

                    @if($queue->status === 'waiting')
                        <form method="POST" action="{{ route('admin.queues.call', $queue->id) }}" class="inline">
                            @csrf
                            <button class="bg-green-600 text-white px-3 py-1 rounded">
                                Panggil
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.queues.skip', $queue->id) }}" class="inline">
                            @csrf
                            <button class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Skip
                            </button>
                        </form>
                    @endif

                    @if($queue->status === 'called')
                        <form method="POST" action="{{ route('admin.queues.done', $queue->id) }}" class="inline">
                            @csrf
                            <button class="bg-blue-600 text-white px-3 py-1 rounded">
                                Selesai
                            </button>
                        </form>
                    @endif

                </div>

            </div>
        @empty
            <p class="text-gray-500">Belum ada antrian hari ini.</p>
        @endforelse

    </div>
</x-app-layout>
