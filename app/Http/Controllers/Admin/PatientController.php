<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'nullable',
            'phone' => 'nullable',
            'patient_type' => 'required|in:umum,bpjs',
            'bpjs_number' => 'nullable',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'address' => 'nullable',
        ]);

        Patient::create($request->all());

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required',
            'patient_type' => 'required|in:umum,bpjs',
        ]);

        $patient->update($request->all());

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Data pasien berhasil diupdate.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return back()->with('success', 'Pasien berhasil dihapus.');
    }
}