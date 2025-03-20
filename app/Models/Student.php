<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    protected $fillable = ['group_id', 'name'];
    public $timestamps = false;

    public function grade(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function attendance(): HasOne
    {
        return $this->hasOne(Attendance::class);
    }

    public function Group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
