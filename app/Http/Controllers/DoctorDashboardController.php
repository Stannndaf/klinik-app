<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $doctor = Doctor::where('user_id', $user->id)->first();

        if (!$doctor) {
            abort(403, 'Dokter tidak terhubung.');
        }

        $today = now()->toDateString();

        $waiting = Appointment::with('vital')
            ->whereHas('slot', function ($q) use ($today, $doctor) {
                $q->where('date', $today)
                  ->where('doctor_id', $doctor->id);
            })
            ->where('status', 'waiting_doctor')
            ->orderBy('queue_number')
            ->get();

        $currentCalled = Appointment::with('vital')
            ->whereHas('slot', function ($q) use ($today, $doctor) {
                $q->where('date', $today)
                  ->where('doctor_id', $doctor->id);
            })
            ->where('status', 'called')
            ->first();

        return view('doctor.dashboard', compact(
            'waiting',
            'currentCalled'
        ));
    }

    // ===============================
    // PANGGIL PASIEN
    // ===============================
    public function call(Appointment $appointment)
    {
        if ($appointment->status !== 'waiting_doctor') {
            return back()->with('error', 'Pasien belum siap diperiksa.');
        }

        Appointment::whereHas('slot', function ($q) use ($appointment) {
                $q->where('doctor_id', $appointment->slot->doctor_id);
            })
            ->where('status', 'called')
            ->update(['status' => 'waiting_doctor']);

        $appointment->update([
            'status' => 'called'
        ]);

        // 🔥 BROADCAST UPDATE
        event(new \App\Events\AppointmentStatusUpdated($appointment));

        return back()->with('success', 'Pasien dipanggil.');
    }

    // ===============================
    // SELESAI PEMERIKSAAN + SIMPAN REKAM MEDIS
    // ===============================
    public function done(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'called') {
            return back()->with('error', 'Pasien belum dipanggil.');
        }

        $appointment->update([
            'medical_notes' => $request->medical_notes,
            'status' => 'done'
        ]);

        // 🔥 BROADCAST UPDATE
        event(new \App\Events\AppointmentStatusUpdated($appointment));

        return back()->with('success', 'Pemeriksaan selesai.');
    }
}