<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'appointment_id',
        'description',
        'request_date',
        'status',
    ];
}
