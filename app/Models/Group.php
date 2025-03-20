<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
