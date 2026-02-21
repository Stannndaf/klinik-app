<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
    'patient_id',
    'slot_id',
    'source',
    'status',
    'queue_number',
    'checkin_time',
    'insurance_type',
    'bpjs_number',
];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(\App\Models\MedicalRecord::class);
    }
    public function vital()
    {
        return $this->hasOne(\App\Models\Vital::class);
    }
}