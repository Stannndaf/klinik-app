<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Vital;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NurseController extends Controller
{
    // ===============================
    // DASHBOARD NURSE
    // ===============================
    public function index()
    {
        $today = now()->toDateString();

        $checkedIn = Appointment::whereHas('slot', function ($q) use ($today) {
                $q->where('date', $today);
            })
            ->where('status', 'checked_in')
            ->orderBy('queue_number')
            ->get();

        $currentVital = Appointment::where('status', 'vital')->first();

        return view('nurse.dashboard', compact(
            'checkedIn',
            'currentVital'
        ));
    }

    // ===============================
    // FORM CREATE PATIENT
    // ===============================
    public function createPatient()
    {
        return view('nurse.create-patient');
    }

    // ===============================
    // STORE PATIENT + USER
    // ===============================
    public function storePatient(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'nik' => 'required|unique:patients,nik',
            'patient_type' => 'required|in:umum,bpjs',
            'bpjs_number' => 'nullable|required_if:patient_type,bpjs|unique:patients,bpjs_number',
            'birth_date' => 'required|date',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->birth_date), // default password
                'role' => 'patient',
                'is_active' => true,
            ]);

            Patient::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'nik' => $request->nik,
                'phone' => $request->phone,
                'patient_type' => $request->patient_type,
                'bpjs_number' => $request->patient_type === 'bpjs'
                    ? $request->bpjs_number
                    : null,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('nurse.dashboard')
            ->with('success', 'Pasien berhasil dibuat.');
    }

    // ===============================
    // PANGGIL KE VITAL
    // ===============================
    public function callToVital(Appointment $appointment)
    {
        if ($appointment->status !== 'checked_in') {
            return back()->with('error', 'Pasien belum check-in.');
        }

        $vitalExists = Appointment::where('status', 'vital')->exists();

        if ($vitalExists) {
            return back()->with('error', 'Masih ada pasien di ruang vital.');
        }

        $appointment->update([
            'status' => 'vital'
        ]);

        event(new \App\Events\AppointmentStatusUpdated($appointment));

        return back()->with('success', 'Pasien dipanggil ke ruang vital.');
    }

    // ===============================
    // SELESAI VITAL
    // ===============================
    public function vitalDone(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'vital') {
            return back()->with('error', 'Pasien tidak berada di ruang vital.');
        }

        Vital::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'blood_pressure' => $request->blood_pressure,
                'temperature' => $request->temperature,
                'pulse' => $request->pulse,
                'notes' => $request->notes,
            ]
        );

        $appointment->update([
            'status' => 'waiting_doctor'
        ]);

        event(new \App\Events\AppointmentStatusUpdated($appointment));

        return back()->with('success', 'Vital selesai. Pasien masuk waiting dokter.');
    }
}