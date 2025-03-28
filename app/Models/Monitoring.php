<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Monitoring extends Model
{
    protected $fillable = ['name', 'user_id', 'start_date', 'end_date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function subject(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
