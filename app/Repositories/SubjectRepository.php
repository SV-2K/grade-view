<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class SubjectRepository
{
    public function getSubjectId(string $subjectName): int
    {
        $subjectId = Subject::where('name', $subjectName)
            ->value('id');
        return $subjectId;
    }
    public function getAverageGrade(int $subjectId): float
    {
        $averageGrade = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->where('subjects.id', $subjectId)
            ->avg('grade');
        return $averageGrade;
    }

    public function getAbsolutePerformance(int $subjectId): float
    {
        $absolutePerformance = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->where('subjects.id', $subjectId)
            ->select(DB::raw(
                'SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance'
            ))
            ->first()
            ->absolute_performance;
        return $absolutePerformance;
    }

    public function getQualityPerformance(int $subjectId): float
    {
        $qualityPerformance = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->where('subjects.id', $subjectId)
            ->select(DB::raw(
                'SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance'
            ))
            ->first()
            ->quality_performance;
        return $qualityPerformance;
    }

    public function getGroupsAmount(int $subjectId): int
    {
        $groupsAmount = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->where('subjects.id', $subjectId)
            ->distinct()
            ->count('groups.id');
        return $groupsAmount;
    }

    public function getStudentsAmount(int $subjectId): int
    {
        $studentsAmount = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->where('subjects.id', $subjectId)
            ->distinct()
            ->count();
        return $studentsAmount;
    }
}
