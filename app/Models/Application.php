<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name_th',
        'name_en',
        'status',
        'application_admin'
    ];
}
