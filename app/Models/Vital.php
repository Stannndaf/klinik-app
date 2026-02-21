<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    public function appointment()
{
    return $this->belongsTo(\App\Models\Appointment::class);
}
}
