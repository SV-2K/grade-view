<?php

namespace App\Repositories\College;

use App\Models\Monitoring;

class CollegeStatsRepository
{
    private int $monitoringId;

    public function setMonitoringId(int $monitoringId): void
    {
        $this->monitoringId = $monitoringId;
    }


    public function getAverageGrade(): float
    {
        $averageGrade = Monitoring::join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->whereMonitoringId($this->monitoringId)
            ->avg('grade');
        return $averageGrade;
    }

    public function getAbsolutePerformance(): float
    {
        $absolutePerformance = Monitoring::join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance'
            )
            ->whereMonitoringId($this->monitoringId)
            ->first()
            ->absolute_performance;
        return $absolutePerformance;
    }

    public function getQualityPerformance(): float
    {
        $qualityPerformance = Monitoring::join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance'
            )
            ->whereMonitoringId($this->monitoringId)
            ->first()
            ->quality_performance;
        return $qualityPerformance;
    }

    public function getStudentsAmount(): int
    {
        $studentsAmount = Monitoring::join('groups', 'monitorings.id', '=', 'groups.monitoring_id')
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->whereMonitoringId($this->monitoringId)
            ->count('students.id');
        return $studentsAmount;
    }

    public function getGroupsAmount(): int
    {
        $groupsAmount = Monitoring::join('groups', 'monitorings.id', '=', 'groups.monitoring_id')
            ->whereMonitoringId($this->monitoringId)
            ->count('groups.id');
        return $groupsAmount;
    }

    public function getGradesAmount(): int
    {
        $gradesAmount = Monitoring::join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->whereMonitoringId($this->monitoringId)
            ->count('grades.grade');
        return $gradesAmount;
    }
}
