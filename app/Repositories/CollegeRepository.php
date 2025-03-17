<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CollegeRepository
{
    public function getAverageGrade(): float
    {
        return DB::table('grades')
            ->avg('grades.grade');
    }

    public function getAbsolutePerformance(): float
    {
        return DB::table('grades')
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance'
            )
            ->first()
            ->absolute_performance;
    }

    public function getQualityPerformance(): float
    {
        return DB::table('grades')
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance'
            )
            ->first()
            ->quality_performance;
    }

    public function getStudentsAmount(): int
    {
        return DB::table('students')
            ->count('students.id');
    }

    public function getGroupsAmount(): int
    {
        return DB::table('groups')
            ->count('groups.id');
    }
}
