<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Waiting List Hari Ini</h2>

        @foreach($appointments as $appointment)
            <div class="border p-4 rounded mb-4 flex justify-between items-center">

                <div>
                    <p><strong>No:</strong> {{ $appointment->queue_number }}</p>
                    <p><strong>Nama:</strong> {{ $appointment->user->name ?? 'Walk-in' }}</p>
                    <p><strong>Status:</strong> {{ $appointment->status }}</p>
                </div>

                <div class="flex gap-2">
                    @if($appointment->status === 'waiting')
                        <form method="POST" action="{{ route('admin.appointments.call', $appointment->id) }}">
                            @csrf
                            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                                Panggil
                            </button>
                        </form>
                    @endif

                    @if($appointment->status === 'called')
                        <form method="POST" action="{{ route('admin.appointments.done', $appointment->id) }}">
                            @csrf
                            <button class="bg-green-600 text-white px-4 py-2 rounded">
                                Selesai
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        @endforeach
    </div>
</x-app-layout>