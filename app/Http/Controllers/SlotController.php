<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::orderByDesc('date')->get();
        return view('admin.slots.index', compact('slots'));
    }

    public function store(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'capacity' => 'required|integer|min:1'
    ]);

    Slot::create([
        'doctor_id' => $request->doctor_id, // 🔥 INI YANG KURANG
        'date' => $request->date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'capacity' => $request->capacity,
        'is_active' => true
    ]);

    return back()->with('success','Slot berhasil dibuat');
}

    public function toggle(Slot $slot)
    {
        $slot->update([
            'is_active' => !$slot->is_active
        ]);

        return back();
    }
}