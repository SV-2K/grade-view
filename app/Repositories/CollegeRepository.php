<?php

namespace App\Repositories;

use App\Models\Monitoring;
use Illuminate\Support\Facades\DB;

class CollegeRepository
{
    public function getAverageGrade(int $monitoringId): float
    {
        $averageGrade = Monitoring::join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->whereMonitoringId($monitoringId)
            ->avg('grade');
        return $averageGrade;
    }

    public function getAbsolutePerformance(int $monitoringId): float
    {
        $absolutePerformance = Monitoring::join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance'
            )
            ->whereMonitoringId($monitoringId)
            ->first()
            ->absolute_performance;
        return $absolutePerformance;
    }

    public function getQualityPerformance(int $monitoringId): float
    {
        $qualityPerformance = Monitoring::join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance'
            )
            ->whereMonitoringId($monitoringId)
            ->first()
            ->quality_performance;
        return $qualityPerformance;
    }

    public function getStudentsAmount(int $monitoringId): int
    {
        $studentsAmount = Monitoring::join('groups', 'monitorings.id', '=', 'groups.monitoring_id')
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->whereMonitoringId($monitoringId)
            ->count('students.id');
        return $studentsAmount;
    }

    public function getGroupsAmount(int $monitoringId): int
    {
        $groupsAmount = Monitoring::join('groups', 'monitorings.id', '=', 'groups.monitoring_id')
            ->whereMonitoringId($monitoringId)
            ->count('groups.id');
        return $groupsAmount;
    }
}
