<?php

use Illuminate\Support\Facades\Route;
use App\Models\Doctor;

Route::get('/doctors/{poli}', function ($poli) {
    return Doctor::where('poli_id', $poli)
        ->where('is_active', true)
        ->get();
});