<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">

        <h2 class="text-2xl font-bold mb-6">Booking & Antrian Saya</h2>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR MESSAGE --}}
        @if(session('error'))
            <div class="p-3 bg-red-100 text-red-700 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif


        {{-- ================= SLOT LIST ================= --}}
        <div class="mb-10">
            <h3 class="text-lg font-semibold mb-4">Slot Hari Ini</h3>

            @forelse($slots as $slot)
                <div class="border p-4 rounded mb-3 flex justify-between items-center">

                    <div>
                        <p class="font-semibold">
                            {{ $slot->start_time }} - {{ $slot->end_time }}
                        </p>
                        <p>Kapasitas: {{ $slot->capacity }}</p>
                    </div>

                    <form method="POST" action="{{ route('booking.store') }}">
                        @csrf
                        <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded">
                            Booking
                        </button>
                    </form>
                </div>
            @empty
                <p>Tidak ada slot tersedia hari ini.</p>
            @endforelse
        </div>


        {{-- ================= APPOINTMENT SAYA ================= --}}
        <div>
            <h3 class="text-lg font-semibold mb-4">Booking Saya</h3>

            @php
                $appointments = auth()->user()->appointments()
                    ->with('slot')
                    ->orderByDesc('created_at')
                    ->get();
            @endphp

            @forelse($appointments as $appointment)
                <div class="border p-5 rounded mb-5 bg-white shadow">

                    <p><strong>Slot:</strong>
                        {{ $appointment->slot->start_time }} -
                        {{ $appointment->slot->end_time }}
                    </p>

                    <p><strong>Status:</strong>
                        <span class="capitalize">
                            {{ $appointment->status }}
                        </span>
                    </p>

                    {{-- ================= QR CHECK-IN ================= --}}
                    @if($appointment->status === 'booked')
                        <div class="mt-4">
                            <p class="font-semibold mb-2">Scan QR untuk Check-in</p>
                            {!! QrCode::size(180)->generate(
                                route('checkin.process', $appointment->id)
                            ) !!}
                        </div>
                    @endif

                    {{-- ================= NOMOR ANTRIAN ================= --}}
                    @if($appointment->status === 'waiting')
                        <div class="mt-4 p-3 bg-green-100 rounded">
                            <p class="text-lg font-bold">
                                Nomor Antrian: {{ $appointment->queue_number }}
                            </p>
                        </div>
                    @endif

                    {{-- ================= CANCELLED ================= --}}
                    @if($appointment->status === 'cancelled')
                        <div class="mt-4 p-3 bg-red-100 rounded">
                            Booking dibatalkan.
                        </div>
                    @endif

                </div>
            @empty
                <p>Belum ada booking.</p>
            @endforelse
        </div>

    </div>
</x-app-layout>