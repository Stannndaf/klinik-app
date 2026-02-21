<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Poli;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('poli')->latest()->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $polis = Poli::where('is_active', true)->get();
        return view('admin.doctors.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'poli_id' => 'required|exists:polis,id',
            'name' => 'required',
        ]);

        Doctor::create([
            'poli_id' => $request->poli_id,
            'name' => $request->name,
            'specialization' => $request->specialization,
            'is_active' => true,
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Dokter berhasil ditambahkan');
    }

    public function edit(Doctor $doctor)
    {
        $polis = Poli::all();
        return view('admin.doctors.edit', compact('doctor', 'polis'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'poli_id' => 'required|exists:polis,id',
            'name' => 'required',
        ]);

        $doctor->update([
            'poli_id' => $request->poli_id,
            'name' => $request->name,
            'specialization' => $request->specialization,
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Dokter berhasil diperbarui');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return back()->with('success', 'Dokter dihapus');
    }
}