<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['monitoring_id', 'student_id', 'subject_id', 'grade'];
}
