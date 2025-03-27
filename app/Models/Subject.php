<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function grade(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(Monitoring::class);
    }
}
