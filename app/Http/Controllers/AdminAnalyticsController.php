<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $month = now()->format('Y-m');

        /*
        |--------------------------------------------------------------------------
        | HARI INI
        |--------------------------------------------------------------------------
        */

        $todayQuery = Appointment::whereHas('slot', function ($q) use ($today) {
            $q->whereDate('date', $today);
        });

        $totalToday = $todayQuery->count();

        $umumToday = (clone $todayQuery)
            ->where('insurance_type', 'umum')
            ->count();

        $bpjsToday = (clone $todayQuery)
            ->where('insurance_type', 'bpjs')
            ->count();

        $doneToday = (clone $todayQuery)
            ->where('status', 'done')
            ->count();

        $cancelToday = (clone $todayQuery)
            ->where('status', 'cancelled')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | BULAN INI
        |--------------------------------------------------------------------------
        */

        $monthQuery = Appointment::whereHas('slot', function ($q) use ($month) {
            $q->where('date', 'like', $month . '%');
        });

        $totalMonth = $monthQuery->count();

        $umumMonth = (clone $monthQuery)
            ->where('insurance_type', 'umum')
            ->count();

        $bpjsMonth = (clone $monthQuery)
            ->where('insurance_type', 'bpjs')
            ->count();

        $doneMonth = (clone $monthQuery)
            ->where('status', 'done')
            ->count();

        $cancelMonth = (clone $monthQuery)
            ->where('status', 'cancelled')
            ->count();

        return view('admin.analytics', compact(
            'totalToday',
            'umumToday',
            'bpjsToday',
            'doneToday',
            'cancelToday',

            'totalMonth',
            'umumMonth',
            'bpjsMonth',
            'doneMonth',
            'cancelMonth'
        ));
    }
}