<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'poli_id',
        'name',
        'specialization',
        'is_active',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
}