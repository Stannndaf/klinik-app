<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = [
    'doctor_id',
    'date',
    'start_time',
    'end_time',
    'capacity',
    'is_active',
];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Sisa kuota otomatis
    public function remainingQuota()
    {
        return $this->quota - $this->appointments()
                ->whereIn('status', ['waiting', 'called'])
                ->count();
    }
}