<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Appointment;

class WalkinController extends Controller
{
    public function process()
    {
        $today = now()->toDateString();

        // 🔥 Ambil slot aktif hari ini
        $slot = Slot::whereDate('date', $today)
            ->where('is_active', true)
            ->first();

        if (!$slot) {
            return redirect()->back()
                ->withErrors(['slot' => 'Slot hari ini belum tersedia.']);
        }

        // 🔥 Cek kuota sisa
        if ($slot->remainingQuota() <= 0) {
            return redirect()->back()
                ->withErrors(['quota' => 'Kuota hari ini sudah habis.']);
        }

        // 🔥 Nomor antrian reset per hari
        $lastNumber = Appointment::whereDate('created_at', $today)
            ->max('queue_number');

        $queueNumber = $lastNumber ? $lastNumber + 1 : 1;

        // 🔥 Buat appointment walk-in
        Appointment::create([
            'user_id' => null, // walk-in tanpa login
            'slot_id' => $slot->id,
            'queue_number' => $queueNumber,
            'source' => 'walkin',
            'status' => 'waiting',
            'checkin_time' => now(),
        ]);

        return redirect('/display')
            ->with('success', 'Nomor antrian Anda: ' . $queueNumber);
    }
}