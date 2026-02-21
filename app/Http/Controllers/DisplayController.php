<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Poli;

class DisplayController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // ========================
        // RUANG VITAL (GLOBAL)
        // ========================
        $vital = Appointment::where('status','vital')
            ->first();

        // ========================
        // LOOP SEMUA POLI
        // ========================
        $polis = Poli::with(['doctors'])->get();

        $displayData = [];

        foreach ($polis as $poli) {

            $called = Appointment::whereHas('slot.doctor', function ($q) use ($poli) {
                    $q->where('poli_id', $poli->id);
                })
                ->where('status','called')
                ->first();

            $waiting = Appointment::whereHas('slot.doctor', function ($q) use ($poli) {
                    $q->where('poli_id', $poli->id);
                })
                ->where('status','waiting_doctor')
                ->orderBy('queue_number')
                ->get();

            $displayData[] = [
                'poli' => $poli->name,
                'called' => $called,
                'waiting' => $waiting
            ];
        }

        return view('display.index', compact(
            'vital',
            'displayData'
        ));
    }
    public function data()
{
    $today = now()->toDateString();

    $vital = \App\Models\Appointment::where('status','vital')
        ->first();

    $polis = \App\Models\Poli::all();

    $result = [];

    foreach ($polis as $poli) {

        $called = \App\Models\Appointment::whereHas('slot.doctor', function ($q) use ($poli) {
                $q->where('poli_id', $poli->id);
            })
            ->where('status','called')
            ->first();

        $waiting = \App\Models\Appointment::whereHas('slot.doctor', function ($q) use ($poli) {
                $q->where('poli_id', $poli->id);
            })
            ->where('status','waiting_doctor')
            ->orderBy('queue_number')
            ->get()
            ->pluck('queue_number');

        $result[] = [
            'poli' => $poli->name,
            'called' => $called?->queue_number,
            'waiting' => $waiting
        ];
    }

    return response()->json([
        'vital' => $vital?->queue_number,
        'polis' => $result
    ]);
}
}