<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Tampilkan slot aktif hari ini
    public function index()
    {
        $today = now()->toDateString();

        $slots = Slot::with(['poli', 'doctor'])
            ->whereDate('date', $today)
            ->where('is_active', true)
            ->get();

        return view('patient.dashboard', compact('slots'));
    }

    // Booking slot online
    public function store(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:slots,id',
        ]);

        $slot = Slot::findOrFail($request->slot_id);

        // 🔥 CEK KUOTA SISA
        if ($slot->remainingQuota() <= 0) {
            return back()->withErrors([
                'quota' => 'Kuota hari ini sudah habis.'
            ]);
        }

        // 🔥 CEK SUDAH BOOKING ATAU BELUM
        $alreadyBooked = Appointment::where('user_id', Auth::id())
            ->where('slot_id', $slot->id)
            ->whereIn('status', ['waiting', 'called'])
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors([
                'booking' => 'Anda sudah mengambil antrian hari ini.'
            ]);
        }

        // 🔥 NOMOR ANTRIAN RESET PER HARI
        $today = now()->toDateString();

        $lastNumber = Appointment::whereDate('created_at', $today)
            ->max('queue_number');

        $queueNumber = $lastNumber ? $lastNumber + 1 : 1;

        // 🔥 BUAT APPOINTMENT
        Appointment::create([
            'user_id' => Auth::id(),
            'slot_id' => $slot->id,
            'queue_number' => $queueNumber,
            'source' => 'online',
            'status' => 'waiting',
        ]);

        return back()->with('success', 'Booking berhasil. Nomor antrian Anda: ' . $queueNumber);
    }
}