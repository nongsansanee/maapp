<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Request extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'requester',
        'date_request',
        'application_id',
        'type_request',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function RequestTimeline(): HasMany
    {
        return $this->hasMany(RequestTimeline::class);
    }

    public function latestTimeline()
    {
        return $this->hasOne(RequestTimeline::class)->latestOfMany();
    }

    protected function hashedKey(): Attribute
    {
        return Attribute::make(
            get:function() {
                $hasher = new Hashids(config('app.key'), 5);
                return $hasher->encode($this->attributes['id']);
            }
        );
    }
}
