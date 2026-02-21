<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6">
        🖥 Live Monitoring Klinik
    </h2>

    {{-- FILTER POLI --}}
    <form method="GET" class="mb-6">
        <select name="poli_id"
            onchange="this.form.submit()"
            class="border px-3 py-2 rounded">

            <option value="">Semua Poli</option>

            @foreach($polis as $poli)
                <option value="{{ $poli->id }}"
                    {{ $selectedPoli == $poli->id ? 'selected' : '' }}>
                    {{ $poli->name }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- LIVE BOARD --}}
    @forelse($appointments as $poliName => $items)

        <div class="bg-white shadow rounded p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">
                🏥 {{ $poliName }}
            </h3>

            @php
                $vital = $items->where('status','vital')->first();
                $waitingDoctor = $items->where('status','waiting_doctor');
                $called = $items->where('status','called')->first();
                $checkedIn = $items->where('status','checked_in');
            @endphp

            <div class="grid grid-cols-4 gap-4">

                {{-- VITAL --}}
                <div class="bg-purple-100 p-4 rounded">
                    <h4 class="font-semibold mb-2">🟣 Vital</h4>
                    @if($vital)
                        <p>No {{ $vital->queue_number }}</p>
                        <p>{{ $vital->patient->name }}</p>
                    @else
                        <p class="text-gray-400">-</p>
                    @endif
                </div>

                {{-- WAITING DOCTOR --}}
                <div class="bg-orange-100 p-4 rounded">
                    <h4 class="font-semibold mb-2">🟠 Waiting Doctor</h4>
                    @forelse($waitingDoctor as $w)
                        <p>No {{ $w->queue_number }} - {{ $w->patient->name }}</p>
                    @empty
                        <p class="text-gray-400">-</p>
                    @endforelse
                </div>

                {{-- SEDANG DIPERIKSA --}}
                <div class="bg-blue-100 p-4 rounded">
                    <h4 class="font-semibold mb-2">🔵 Sedang Diperiksa</h4>
                    @if($called)
                        <p>No {{ $called->queue_number }}</p>
                        <p>{{ $called->patient->name }}</p>
                    @else
                        <p class="text-gray-400">-</p>
                    @endif
                </div>

                {{-- CHECKED IN --}}
                <div class="bg-green-100 p-4 rounded">
                    <h4 class="font-semibold mb-2">🟢 Ruang Tunggu</h4>
                    @forelse($checkedIn as $c)
                        <p>No {{ $c->queue_number }} - {{ $c->patient->name }}</p>
                    @empty
                        <p class="text-gray-400">-</p>
                    @endforelse
                </div>

            </div>

        </div>

    @empty
        <div class="bg-gray-100 p-6 rounded text-center text-gray-500">
            Tidak ada antrian aktif hari ini.
        </div>
    @endforelse

</div>
</x-app-layout>