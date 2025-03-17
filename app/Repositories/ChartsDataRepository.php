<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class ChartsDataRepository
{
    public function getCategories(string $targetTable, ?string $sourceTable = null, ?int $id = null): array
    {
        //for example can return each subject($targetTable) that group($sourceTable) studying
        //or each group($targetTable) that studying the group($sourceTable)
        $query = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id');
        if ($sourceTable != null || $id != null) {
            $query->where("{$sourceTable}.id", $id);
        }
        $groups = $query->distinct()
            ->pluck("{$targetTable}.name")
            ->toArray();
        return $groups;
    }

    public function getGradesForEachCategory(string $mainTable, string $groupByTable, int $id): array
    {
        // for example can return grades for each subject($groupByEntity) that the group($mainEntity) studying
        // or for each group($groupByEntity) that that studying the subject($mainEntity)
        $data = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->where("{$mainTable}.id", $id)
            ->selectRaw("
                SUM(CASE WHEN grades.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
                SUM(CASE WHEN grades.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
                SUM(CASE WHEN grades.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
                SUM(CASE WHEN grades.grade = 2 THEN 1 ELSE 0 END) AS grade_2,
                {$groupByTable}.id AS group_id
            ")
            ->groupBy("{$groupByTable}.id")
            ->get();

        $gradesForEachCategory = [
            ['5'], ['4'], ['3'], ['2']
        ];

        foreach ($data as $row) {
            $gradesForEachCategory[0][] = $row->grade_5;
            $gradesForEachCategory[1][] = $row->grade_4;
            $gradesForEachCategory[2][] = $row->grade_3;
            $gradesForEachCategory[3][] = $row->grade_2;
        }

        return $gradesForEachCategory;
    }

    public function getAverageGrades(string $groupByTable, ?string $mainTable = null, ?int $id = null): array
    {
        $query = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id')
            ->select(DB::raw('ROUND(AVG(`grades`.grade), 2) AS average_grade'));
            if ($mainTable != null || $id != null) {
                $query->where("$mainTable.id", $id);
            }
            $averageGrades = $query->groupBy("$groupByTable.name")
            ->pluck('average_grade')
            ->toArray();
        #chart is not working correctly without first element ot array being empty
        array_unshift($averageGrades, '');
        return $averageGrades;
    }

    public function getGradesAmount(?string $mainTable = null, ?int $id = null): array
    {
        $query = Subject::join('grades', 'subjects.id', '=', 'grades.subject_id')
            ->join('students', 'students.id', '=', 'grades.student_id')
            ->join('groups', 'groups.id', '=', 'students.group_id');
        if ($mainTable != null) {
            $query->where("$mainTable.id", $id);
        }
        $gradesAmount = $query->select(DB::raw(
                'SUM(CASE WHEN `grades`.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
                SUM(CASE WHEN `grades`.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
                SUM(CASE WHEN `grades`.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
                SUM(CASE WHEN `grades`.grade = 2 THEN 1 ELSE 0 END) AS grade_2'
            ))->first();
        return [
            ['5', $gradesAmount->grade_5],
            ['4', $gradesAmount->grade_4],
            ['3', $gradesAmount->grade_3],
            ['2', $gradesAmount->grade_2]
        ];
    }

    public function getAttendance(?int $groupId = null): array
    {
        $query = Group::join('students', 'groups.id', '=', 'students.group_id')
            ->join('attendances', 'students.id', '=', 'attendances.student_id')
            ->select(DB::raw(
                'SUM(attendances.unexcused_hours) AS valid_hours,
                SUM(attendances.excused_hours) AS invalid_hours'
            ));
        if ($groupId != null) {
            $query->where('groups.id', $groupId);
        }
        $stmt = $query->first();

        return [
            ['Ув', $stmt->valid_hours],
            ['Н/ув', $stmt->invalid_hours],
        ];
    }

    public function getQualityPerformance(?int $groupId = null): array
    {
        $query = Group::
        join('students', 'groups.id', '=', 'students.group_id')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->join('subjects', 'subjects.id', '=', 'grades.subject_id')
            ->selectRaw(
                '(SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100.0) /
                SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance'
            );
        if ($groupId != null) {
            $query->where('groups.id', $groupId);
        }
        $stmt = $query->groupBy('subjects.id')
            ->get();

        $performance = [''];

        foreach ($stmt as $row) {
            $performance[] = $row->quality_performance;
        }
        return $performance;
    }
}
