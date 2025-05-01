<?php

namespace App\Repositories;

use App\Models\Group;
use Illuminate\Support\Facades\DB;

class GroupRepository
{
    public function getGroupId(int $monitoringId, ?string $groupName): int|null
    {
        $groupId = Group::where('name', $groupName)
            ->whereMonitoringId($monitoringId)
            ->value('id');
        return $groupId;
    }
    public function getAverageGrade(int $groupId): float
    {
        $averageGrade = Group::join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->whereGroupId($groupId)
            ->avg('grade');
        return $averageGrade;
    }

    public function getAbsolutePerformance(int $groupId): float
    {
        $absolutePerformance = Group::join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->select(DB::raw(
                'SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance'
            ))
            ->whereGroupId($groupId)
            ->first()
            ->absolute_performance;
        return $absolutePerformance;
    }

    public function getQualityPerformance(int $groupId): float
    {
        $qualityPerformance = Group::join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->select(DB::raw(
                'SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance'
            ))
            ->whereGroupId($groupId)
            ->first()
            ->quality_performance;
        return $qualityPerformance;
    }

    public function getStudentsAmount(int $groupId): int
    {
        $studentsAmount = Group::join('students', 'groups.id', '=', 'students.group_id')
            ->whereGroupId($groupId)
            ->count('students.id');
        return $studentsAmount;
    }

    public function getGradesAmount(int $groupId): int
    {
        $gradesAmount = Group::join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->whereGroupId($groupId)
            ->count('grades.grade');
        return $gradesAmount;
    }
}

