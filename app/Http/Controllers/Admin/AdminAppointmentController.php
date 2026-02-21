<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $month = now()->format('Y-m');

        $appointments = Appointment::whereHas('slot', function ($q) use ($today) {
                $q->where('date', $today);
            })
            ->whereIn('status', [
                'waiting',
                'checked_in',
                'called',
                'vital',
                'vital_done'
            ])
            ->orderByRaw("
                CASE 
                    WHEN status = 'called' THEN 1
                    WHEN status = 'checked_in' THEN 2
                    WHEN status = 'waiting' THEN 3
                    WHEN status = 'vital' THEN 4
                    WHEN status = 'vital_done' THEN 5
                END
            ")
            ->orderBy('queue_number')
            ->get();

        $hasCalled = Appointment::whereHas('slot', function ($q) use ($today) {
                $q->where('date', $today);
            })
            ->where('status','called')
            ->exists();

        $todayStats = Appointment::whereHas('slot', function ($q) use ($today) {
                $q->where('date', $today);
            });

        $totalToday = (clone $todayStats)->count();
        $totalUmumToday = (clone $todayStats)->where('insurance_type','umum')->count();
        $totalBpjsToday = (clone $todayStats)->where('insurance_type','bpjs')->count();
        $doneToday = (clone $todayStats)->where('status','done')->count();

        $monthStats = Appointment::whereHas('slot', function ($q) use ($month) {
                $q->where('date','like', $month.'%');
            });

        $totalMonth = (clone $monthStats)->count();
        $totalUmumMonth = (clone $monthStats)->where('insurance_type','umum')->count();
        $totalBpjsMonth = (clone $monthStats)->where('insurance_type','bpjs')->count();

        return view('admin.dashboard', compact(
            'appointments',
            'hasCalled',
            'totalToday',
            'totalUmumToday',
            'totalBpjsToday',
            'doneToday',
            'totalMonth',
            'totalUmumMonth',
            'totalBpjsMonth'
        ));
    }

    public function call(Appointment $appointment)
    {
        if ($appointment->status !== 'checked_in') {
            return back()->with('error', 'Pasien belum check-in.');
        }

        Appointment::where('status', 'called')
            ->update(['status' => 'checked_in']);

        $appointment->update([
            'status' => 'called'
        ]);

        return back()->with('success', 'Pasien dipanggil.');
    }

    public function toVital(Appointment $appointment)
    {
        if ($appointment->status !== 'called') {
            return back()->with('error', 'Pasien belum dipanggil.');
        }

        $appointment->update([
            'status' => 'vital'
        ]);

        return back()->with('success', 'Pasien masuk ruang vital.');
    }

    public function done(Appointment $appointment)
    {
        if ($appointment->status !== 'vital_done') {
            return back()->with('error', 'Vital belum selesai.');
        }

        $appointment->update(['status' => 'done']);

        return back()->with('success','Pemeriksaan selesai.');
    }

    public function skip(Appointment $appointment)
    {
        if (!in_array($appointment->status, ['waiting','checked_in'])) {
            return back()->with('error','Tidak bisa skip pada status ini.');
        }

        $appointment->update(['status' => 'skipped']);

        return back()->with('success','Pasien dilewati.');
    }

    public function history()
    {
        $history = Appointment::whereIn('status', [
                'done',
                'skipped'
            ])
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.history', compact('history'));
    }
    public function live(Request $request)
    {
        $today = now()->toDateString();

        $selectedPoli = $request->poli_id;

        $appointments = Appointment::with(['patient', 'slot.doctor.poli'])
            ->whereHas('slot', function ($q) use ($today, $selectedPoli) {
                $q->where('date', $today);

                if ($selectedPoli) {
                    $q->whereHas('doctor.poli', function ($p) use ($selectedPoli) {
                        $p->where('id', $selectedPoli);
                    });
                }
            })
            ->whereIn('status', [
                'checked_in',
                'vital',
                'waiting_doctor',
                'called'
            ])
            ->get()
            ->groupBy(function ($item) {
                return $item->slot->doctor->poli->name ?? 'Tanpa Poli';
            });

        $polis = \App\Models\Poli::all();

        return view('admin.live', compact(
            'appointments',
            'polis',
            'selectedPoli'
        ));
    }
}