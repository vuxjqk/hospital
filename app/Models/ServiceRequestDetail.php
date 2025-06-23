<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestDetail extends Model
{
    protected $fillable = [
        'service_id',
        'service_request_id',
        'note',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function service_request()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function service_result()
    {
        return $this->belongsTo(ServiceResult::class);
    }
}
