<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceResult extends Model
{
    protected $fillable = [
        'service_request_details_id',
        'created_by',
        'result',
        'result_file',
        'result_date',
    ];
}
