<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class Habit extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $log) {
            $log->uuid = $log->uuid ?? (string) Str::uuid();
        });

        static::updating(function (self $log) {
            if($log->isDirty('uuid')) {
                $log->uuid = $log->getOriginal('uuid');
            }
        });
    }

    public function logs(): HasMany
    {
        return $this->hasMany(HabitLog::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
