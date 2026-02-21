<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class CheckinController extends Controller
{
    public function process(Appointment $appointment)
    {
        // ❌ Jika sudah check-in / sudah dipanggil / sudah lewat tahap
        if ($appointment->status !== 'waiting') {
            return redirect()->route('kiosk.index')
                ->with('error', 'Check-in sudah dilakukan sebelumnya.');
        }

        // ✅ Update hanya sekali
        $appointment->update([
            'status' => 'checked_in',
            'checkin_time' => now(),
        ]);

        return redirect()->route('kiosk.index')
            ->with('success', 'Check-in berhasil. Silakan tunggu dipanggil.');
    }
}