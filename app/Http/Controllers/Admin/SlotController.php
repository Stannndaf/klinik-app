<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slot;
use App\Models\Doctor;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::with('doctor.poli')->latest()->get();
        return view('admin.slots.index', compact('slots'));
    }

    public function create()
    {
        $doctors = Doctor::with('poli')
            ->where('is_active', true)
            ->get();

        return view('admin.slots.create', compact('doctors'));
    }

    public function store(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'capacity' => 'required|integer|min:1|max:200',
    ]);

    $doctor = Doctor::findOrFail($request->doctor_id);

    if (!$doctor->is_active) {
        return back()->withErrors(['doctor_id' => 'Dokter tidak aktif.']);
    }

    Slot::create([
        'doctor_id' => $request->doctor_id,
        'date' => $request->date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'capacity' => $request->capacity,
        'is_active' => true,
    ]);

    return redirect()->route('admin.slots.index')
        ->with('success', 'Slot berhasil dibuat');
}

    public function edit(Slot $slot)
    {
        $doctors = Doctor::with('poli')->get();
        return view('admin.slots.edit', compact('slot', 'doctors'));
    }

    public function update(Request $request, Slot $slot)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'capacity' => 'required|integer|min:1',
        ]);

        $slot->update($request->all());

        return redirect()->route('admin.slots.index')
            ->with('success', 'Slot berhasil diperbarui.');
    }

    public function destroy(Slot $slot)
    {
        $slot->delete();

        return redirect()->route('admin.slots.index')
            ->with('success', 'Slot berhasil dihapus.');
    }
}