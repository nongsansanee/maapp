<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestTimeline extends Model
{
    
    protected $fillable = [
        'request_id',
        'name',
        'status_request',
    ];
}
