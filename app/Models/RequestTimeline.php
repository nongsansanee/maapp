<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestTimeline extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'request_id',
        'name',
        'status_request',
    ];
}
