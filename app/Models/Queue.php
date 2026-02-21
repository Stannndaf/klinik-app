<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
  protected $fillable = [
    'user_id',
    'doctor_id',
    'queue_number',
    'queue_date',
    'status'
];

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

public function doctor()
{
    return $this->belongsTo(\App\Models\Doctor::class);
}


}
