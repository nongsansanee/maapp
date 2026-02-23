<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Application extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_th',
        'name_en',
        'status',
        'application_admin'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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
