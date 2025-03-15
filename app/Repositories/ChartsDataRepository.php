<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class ChartsDataRepository
{
    public function getGroups(int $subjectId): array
    {
        $groups = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->where('subjects.id', $subjectId)
            ->distinct()
            ->pluck('groups.name')
            ->toArray();
        return $groups;
    }

    public function getSubjectId(string $subjectName): int
    {
        $subjectId = Subject::where('name', $subjectName)
            ->value('id');
        return $subjectId;
    }

    public function getGradesForEachGroup(int $subjectId): array
    {
        $data = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->where('subjects.id', $subjectId)
            ->selectRaw("
                SUM(CASE WHEN grades.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
                SUM(CASE WHEN grades.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
                SUM(CASE WHEN grades.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
                SUM(CASE WHEN grades.grade = 2 THEN 1 ELSE 0 END) AS grade_2,
                groups.id AS group_id
            ")
            ->groupBy('groups.id')
            ->get();

        $gradesForEachGroup = [
            ['5'], ['4'], ['3'], ['2']
        ];

        foreach ($data as $row) {
            $gradesForEachGroup[0][] = $row->grade_5;
            $gradesForEachGroup[1][] = $row->grade_4;
            $gradesForEachGroup[2][] = $row->grade_3;
            $gradesForEachGroup[3][] = $row->grade_2;
        }

        return $gradesForEachGroup;
    }

    public function getAverageGrades(int $subjectId):array
    {
        $averageGrades = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->select(DB::raw('ROUND(AVG(`grades`.grade), 2) AS average_grade'))
            ->where('subjects.id', $subjectId)
            ->groupBy('groups.name')
            ->pluck('average_grade')
            ->toArray();
        #chart is not working correctly without first element ot array being empty
        array_unshift($averageGrades, '');
        return $averageGrades;
    }

    public function getGradesAmount(int $subjectId): array
    {
        $gradesAmount = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->where('subjects.id', $subjectId)
            ->select(DB::raw(
                'SUM(CASE WHEN `grades`.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
                SUM(CASE WHEN `grades`.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
                SUM(CASE WHEN `grades`.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
                SUM(CASE WHEN `grades`.grade = 2 THEN 1 ELSE 0 END) AS grade_2'
            ))
            ->first();
        return [
            ['5', $gradesAmount->grade_5],
            ['4', $gradesAmount->grade_4],
            ['3', $gradesAmount->grade_3],
            ['2', $gradesAmount->grade_2]
        ];
    }
}
