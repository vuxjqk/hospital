<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'type',
        'record_date',
        'has_insurance',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
