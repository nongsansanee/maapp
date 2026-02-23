<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    protected function hashedKey():Attribute
    {
        return Attribute::make(
            get:function(){
                $hasher = new Hashids(config('app.key'),5);
                return $hasher->encode($this->attributes['id']);
            }
        );
    }
}
