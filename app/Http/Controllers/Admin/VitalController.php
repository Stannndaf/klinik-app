<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class VitalController extends Controller
{
    public function edit(Appointment $appointment)
    {
        // 🔒 Hanya boleh jika sudah dipanggil atau sedang vital
        if (!in_array($appointment->status, ['called', 'vital'])) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Pasien belum dipanggil.');
        }

        $patient = $appointment->patient;

        if (!$patient) {
            abort(404, 'Patient tidak ditemukan.');
        }

        // 🟢 Saat pertama kali masuk halaman vital → ubah status jadi "vital"
        if ($appointment->status === 'called') {
            $appointment->update([
                'status' => 'vital'
            ]);
        }

        // Ambil atau buat medical record
        $record = $appointment->medicalRecord;

        if (!$record) {
            $record = MedicalRecord::create([
                'appointment_id' => $appointment->id,
                'patient_id'     => $appointment->patient_id,
            ]);
        }

        // Ambil 5 vital sebelumnya
        $previousVitals = MedicalRecord::where('patient_id', $patient->id)
            ->where('appointment_id', '!=', $appointment->id)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.vital.edit', compact(
            'appointment',
            'patient',
            'record',
            'previousVitals'
        ));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'blood_pressure'    => 'nullable',
            'weight'            => 'nullable|numeric',
            'height'            => 'nullable|numeric',
            'temperature'       => 'nullable|numeric',
            'initial_complaint' => 'nullable',
        ]);

        MedicalRecord::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'patient_id'        => $appointment->patient_id,
                'blood_pressure'    => $request->blood_pressure,
                'weight'            => $request->weight,
                'height'            => $request->height,
                'temperature'       => $request->temperature,
                'initial_complaint' => $request->initial_complaint,
            ]
        );

        // 🟣 Setelah vital selesai → ubah status
        $appointment->update([
            'status' => 'vital_done'
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Vital sign berhasil disimpan.');
    }
}