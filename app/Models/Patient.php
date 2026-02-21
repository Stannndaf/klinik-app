<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    protected $fillable = [
        'patient_code',
        'name',
        'nik',
        'phone',
        'patient_type',
        'bpjs_number',
        'birth_date',
        'gender',
        'address',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {

            DB::transaction(function () use ($patient) {

                $prefix = $patient->patient_type === 'bpjs' ? 'PB-' : 'PU-';

                // Lock row supaya tidak bentrok saat bersamaan
                $lastPatient = self::where('patient_code', 'like', $prefix . '%')
                    ->orderByDesc('patient_code')
                    ->lockForUpdate()
                    ->first();

                if ($lastPatient) {
                    $lastNumber = (int) str_replace($prefix, '', $lastPatient->patient_code);
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }

                $patient->patient_code = $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(\App\Models\MedicalRecord::class);
    }
}