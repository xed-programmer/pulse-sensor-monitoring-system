<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'machine_number',
        'patient_id'
    ];

    public function patient()
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }
}
