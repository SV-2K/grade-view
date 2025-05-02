<?php

namespace App\Repositories\Subject;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

class SubjectChartRepository
{
    private int $subjectId;

    public function setSubjectId(int $subjectId)
    {
        $this->subjectId = $subjectId;
    }

    public function getGradeDistribution(): Collection
    {
        return Subject::query()
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->where('subjects.id', $this->subjectId)
            ->selectRaw('
                SUM(CASE WHEN grades.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
                SUM(CASE WHEN grades.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
                SUM(CASE WHEN grades.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
                SUM(CASE WHEN grades.grade = 2 THEN 1 ELSE 0 END) AS grade_2,
                groups.name AS group_name
            ')
            ->groupBy('groups.id')
            ->get();
    }

    public function getGradesRatio(): Subject
    {
        return Subject::query()
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->where('subjects.id', $this->subjectId)
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
        return Subject::query()
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->selectRaw('
                AVG(`grades`.grade) AS average_grade,
                groups.name as group_name
            ')
            ->where('subjects.id', $this->subjectId)
            ->groupBy('groups.name')
            ->get();
    }
}
