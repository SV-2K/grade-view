<?php

namespace App\Repositories\College;

use App\Models\Group;
use App\Models\Monitoring;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CollegeChartRepository
{
    private int $monitoringId;

    public function setMonitoringId(int $monirotingId): void
    {
        $this->monitoringId = $monirotingId;
    }

    public function getQualityPerformance(): Collection
    {
        return Monitoring::query()
            ->join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->where('monitorings.id', $this->monitoringId)
            ->selectRaw(
                '(SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100.0) /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance,
                teacher_name as teacher_name'
            )
            ->groupBy('subjects.id')
            ->get();
    }

    public function getAttendance(): Monitoring
    {
        return Monitoring::query()
            ->join('groups', 'monitorings.id', '=', 'groups.monitoring_id')
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('attendances', 'students.id', '=', 'attendances.student_id')
            ->selectRaw(
                'SUM(attendances.unexcused_hours) AS valid_hours,
                SUM(attendances.excused_hours) AS invalid_hours'
            )
            ->where('monitorings.id', $this->monitoringId)
            ->first();
    }

    public function getGradesRatio(): Monitoring
    {
        return Monitoring::query()
            ->join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->where('monitorings.id', $this->monitoringId)
            ->selectRaw(
            'SUM(CASE WHEN `grades`.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
                SUM(CASE WHEN `grades`.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
                SUM(CASE WHEN `grades`.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
                SUM(CASE WHEN `grades`.grade = 2 THEN 1 ELSE 0 END) AS grade_2'
            )
            ->first();
    }

    public function getAverageGrades(): Collection
    {
        return Monitoring::query()
            ->join('groups', 'monitorings.id', '=', 'groups.monitoring_id')
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->selectRaw(
                'AVG(`grades`.grade) AS average_grade,
                groups.name as group_name'
            )
            ->where('monitorings.id', $this->monitoringId)
            ->groupBy('groups.name')
            ->get();
    }
}
