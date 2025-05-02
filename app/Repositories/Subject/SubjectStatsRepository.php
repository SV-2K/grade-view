<?php

namespace App\Repositories\Subject;

use App\Models\Subject;

class SubjectStatsRepository
{
    private int $subjectId;

    public function setSubjectId(int $subjectId): void
    {
        $this->subjectId = $subjectId;
    }

    public function getSubjectId(int $monitoringId, ?string $subjectName): int|null
    {
        $subjectId = Subject::query()
            ->where('name', $subjectName)
            ->where('monitoring_id', $monitoringId)
            ->value('id');
        return $subjectId;
    }
    public function getAverageGrade(): float
    {
        $averageGrade = Subject::query()
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->where('subjects.id', $this->subjectId)
            ->avg('grade');
        return $averageGrade;
    }

    public function getAbsolutePerformance(): float
    {
        $absolutePerformance = Subject::query()
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->where('subjects.id', $this->subjectId)
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance'
            )
            ->first()
            ->absolute_performance;
        return $absolutePerformance;
    }

    public function getQualityPerformance(): float
    {
        $qualityPerformance = Subject::query()
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->where('subjects.id', $this->subjectId)
            ->selectRaw(
                'SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100 /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance'
            )
            ->first()
            ->quality_performance;
        return $qualityPerformance;
    }

    public function getGroupsAmount(): int
    {
        $groupsAmount = Subject::query()
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->where('subjects.id', $this->subjectId)
            ->distinct()
            ->count('groups.id');
        return $groupsAmount;
    }

    public function getStudentsAmount(): int
    {
        $studentsAmount = Subject::query()
            ->join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->where('subjects.id', $this->subjectId)
            ->distinct()
            ->count();
        return $studentsAmount;
    }
}
