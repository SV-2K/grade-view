<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Monitoring extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date'];

    public function group(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function subject(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
