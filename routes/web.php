<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\WalkinController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\KioskController;

use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;

use App\Http\Controllers\NurseController;
use App\Http\Controllers\DoctorDashboardController;

/*
|--------------------------------------------------------------------------
| PUBLIC AREA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/display/data', [DisplayController::class, 'data'])
    ->name('display.data');

Route::get('/display', [DisplayController::class, 'index'])
    ->name('display');

/*
|--------------------------------------------------------------------------
| KIOSK
|--------------------------------------------------------------------------
*/

Route::prefix('kiosk')->group(function () {

    Route::get('/', [KioskController::class, 'index'])
        ->name('kiosk.index');

    Route::post('/process', [KioskController::class, 'process'])
        ->name('kiosk.process');

    Route::get('/print/{appointment}', [KioskController::class, 'print'])
        ->name('kiosk.print');
});

/*
|--------------------------------------------------------------------------
| WALK-IN CHECKIN (QR)
|--------------------------------------------------------------------------
*/

Route::get('/walkin-checkin', [WalkinController::class, 'process'])
    ->name('walkin.checkin');

/*
|--------------------------------------------------------------------------
| PATIENT AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:patient'])->group(function () {

    Route::get('/dashboard', [AppointmentController::class, 'index'])
        ->name('patient.dashboard');

    Route::post('/booking', [AppointmentController::class, 'store'])
        ->name('booking.store');

    Route::get('/checkin/{appointment}', [CheckinController::class, 'process'])
        ->name('checkin.process');
});

/*
|--------------------------------------------------------------------------
| NURSE AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:nurse'])
    ->prefix('nurse')
    ->group(function () {

        Route::get('/dashboard', [NurseController::class, 'index'])
            ->name('nurse.dashboard');

        /*
        |------------------------------------------
        | CREATE PATIENT (BARU)
        |------------------------------------------
        */
        Route::get('/patients/create', [NurseController::class, 'createPatient'])
            ->name('nurse.patients.create');

        Route::post('/patients/store', [NurseController::class, 'storePatient'])
            ->name('nurse.patients.store');

        /*
        |------------------------------------------
        | VITAL FLOW
        |------------------------------------------
        */
        Route::post('/appointments/{appointment}/call-vital',
            [NurseController::class, 'callToVital'])
            ->name('nurse.call.vital');

        Route::post('/appointments/{appointment}/vital-done',
            [NurseController::class, 'vitalDone'])
            ->name('nurse.vital.done');

        Route::get('/appointments/{appointment}/vital',
            [NurseController::class, 'editVital'])
            ->name('nurse.vital.edit');
});

/*
|--------------------------------------------------------------------------
| DOCTOR AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:doctor'])
    ->prefix('doctor')
    ->group(function () {

        Route::get('/dashboard',
            [DoctorDashboardController::class, 'index'])
            ->name('doctor.dashboard');

        Route::post('/appointments/{appointment}/call',
            [DoctorDashboardController::class, 'call'])
            ->name('doctor.call');

        Route::post('/appointments/{appointment}/done',
            [DoctorDashboardController::class, 'done'])
            ->name('doctor.done');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminAppointmentController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/history', [AdminAppointmentController::class, 'history'])
            ->name('admin.history');
        Route::get('/live', [AdminAppointmentController::class, 'live'])
            ->name('admin.live');
        /*
        |------------------------------------------
        | TAMBAHAN UNTUK PANGGIL ANTRIAN ADMIN
        |------------------------------------------
        */
        Route::post('/appointments/{appointment}/call',
            [AdminAppointmentController::class, 'call'])
            ->name('admin.appointments.call');

        Route::resource('patients', PatientController::class)
            ->names('admin.patients');

        Route::resource('polis', PoliController::class)
            ->names('admin.polis');

        Route::resource('doctors', DoctorController::class)
            ->names('admin.doctors');

        Route::resource('slots', SlotController::class)
            ->names('admin.slots');
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';