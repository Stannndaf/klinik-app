<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

<h2 class="text-2xl font-bold mb-6">Riwayat Antrian</h2>

<table class="w-full border">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2">No</th>
            <th>Status</th>
            <th>Jenis</th>
            <th>Pasien</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($history as $item)
        <tr class="border-t">
            <td class="p-2">{{ $item->queue_number }}</td>
            <td>{{ strtoupper($item->status) }}</td>
            <td>{{ strtoupper($item->insurance_type ?? 'UMUM') }}</td>
            <td>{{ $item->user->name ?? 'Walk-in' }}</td>
            <td>{{ $item->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>
</x-app-layout>