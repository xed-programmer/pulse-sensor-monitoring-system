<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pulse extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'hr',
        'spo2',
        'patient_id'        
    ];
}
