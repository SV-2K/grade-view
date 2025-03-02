<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'excused_hours', 'unexcused_hours'];
    public $timestamps = false;
}
