<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Slot;
use App\Models\Appointment;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    public function index()
    {
        $polis = Poli::where('is_active', true)->get();
        return view('kiosk.index', compact('polis'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'patient_type' => 'required|in:umum,bpjs',
            'identifier' => 'required',
            'poli_id' => 'required|exists:polis,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        // Cari pasien
        if ($request->patient_type === 'umum') {
            $patient = Patient::where('patient_code', $request->identifier)->first();
        } else {
            $patient = Patient::where('bpjs_number', $request->identifier)->first();
        }

        if (!$patient) {
            return back()->with('error', 'Data pasien tidak ditemukan.');
        }

        $today = now()->toDateString();

        $slot = Slot::whereDate('date', $today)
            ->where('doctor_id', $request->doctor_id)
            ->where('is_active', true)
            ->first();

        if (!$slot) {
            return back()->with('error', 'Jadwal tidak tersedia.');
        }

        $lastNumber = Appointment::whereDate('created_at', $today)
            ->max('queue_number');

        $queueNumber = $lastNumber ? $lastNumber + 1 : 1;

        $appointment = Appointment::create([
    'patient_id' => $patient->id, // 🔥 WAJIB
    'slot_id' => $slot->id,
    'source' => 'kiosk',
    'status' => 'waiting',
    'queue_number' => $queueNumber,
    'checkin_time' => now(),
    'insurance_type' => $request->patient_type,
    'bpjs_number' => $request->identifier,
]);

        return redirect()->route('kiosk.print', $appointment->id);
    }

    public function print(Appointment $appointment)
    {
        return view('kiosk.print', compact('appointment'));
    }
}