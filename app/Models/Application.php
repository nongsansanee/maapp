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

    public function scopeStatusName(): string
    {
        $status = $this->status;
        if($status == 1)
            $data='เปิดใช้งาน';
        else
            $data='ปิดใช้งาน';

        return $data;
    }
}
