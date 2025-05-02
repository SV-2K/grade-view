<?php

namespace App\Repositories\Group;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;

class GroupChartRepository
{
    private int $groupId;

    public function setGroupId(int $groupId): void
    {
        $this->groupId = $groupId;
    }

    public function getGradesRatio(): Group
    {
        return Group::query()
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->where('groups.id', $this->groupId)
            ->selectRaw(
            'SUM(CASE WHEN `grades`.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
                SUM(CASE WHEN `grades`.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
                SUM(CASE WHEN `grades`.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
                SUM(CASE WHEN `grades`.grade = 2 THEN 1 ELSE 0 END) AS grade_2'
            )
            ->first();
    }

    public function getQualityPerformance(): Collection
    {
        return Group::query()
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->join('subjects', 'subjects.id', '=', 'grades.subject_id')
            ->where('groups.id', $this->groupId)
            ->selectRaw(
                '(SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100.0) /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance,
                subjects.name as subject_name'
            )
            ->groupBy('subjects.id')
            ->get();
    }

    public function getAttendance(): Group
    {
        return Group::query()
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('attendances', 'students.id', '=', 'attendances.student_id')
            ->selectRaw(
                'SUM(attendances.unexcused_hours) AS valid_hours,
                SUM(attendances.excused_hours) AS invalid_hours'
            )
            ->where('groups.id', $this->groupId)
            ->first();
    }

    public function getGradeDistribution(): Collection
    {
        return Group::query()
            ->join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->join('subjects', 'subjects.id', '=', 'grades.subject_id')
            ->where('groups.id', $this->groupId)
            ->selectRaw('
                SUM(CASE WHEN grades.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
                SUM(CASE WHEN grades.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
                SUM(CASE WHEN grades.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
                SUM(CASE WHEN grades.grade = 2 THEN 1 ELSE 0 END) AS grade_2,
                subjects.name AS subject_name
            ')
            ->groupBy('subjects.id')
            ->get();
    }
}
