<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'medical_record_id',
        'specialty_id',
        'doctor_id',
        'queue_number',
        'appointment_date',
        'symptoms',
        'diagnosis',
        'note',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medical_record()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
