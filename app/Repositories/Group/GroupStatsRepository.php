<?php

namespace App\Repositories\Group;

use App\Models\Group;
use Illuminate\Support\Facades\DB;

class GroupStatsRepository
{
    private int $groupId;

    public function setGroupId(int $groupId): void
    {
        $this->groupId = $groupId;
    }

    public function getGroupId(int $monitoringId, ?string $groupName): int|null
    {
        $groupId = Group::query()
            ->where('name', $groupName)
            ->whereMonitoringId($monitoringId)
            ->value('id');
        return $groupId;
    }
    public function getAverageGrade(): float
    {
        $averageGrade = Group::query()
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->whereGroupId($this->groupId)
            ->avg('grade');
        return $averageGrade;
    }

    public function getAbsolutePerformance(): float
    {
        $absolutePerformance = Group::query()
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance'
            )
            ->whereGroupId($this->groupId)
            ->first()
            ->absolute_performance;
        return $absolutePerformance;
    }

    public function getQualityPerformance(): float
    {
        $qualityPerformance = Group::query()
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance'
            )
            ->whereGroupId($this->groupId)
            ->first()
            ->quality_performance;
        return $qualityPerformance;
    }

    public function getStudentsAmount(): int
    {
        $studentsAmount = Group::query()
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->whereGroupId($this->groupId)
            ->count('students.id');
        return $studentsAmount;
    }

    public function getGradesAmount(): int
    {
        $gradesAmount = Group::query()
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->whereGroupId($this->groupId)
            ->count('grades.grade');
        return $gradesAmount;
    }
}

