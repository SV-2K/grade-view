<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\Grade;
use function PHPUnit\Framework\isString;

class ExcelParser
{
    private int $rowStarter = 17;
    private int $columnStarter = 4;

    # Все те слова, которые будут считаться за оценку 5
    private array $gradeFiveKeywords = ['зач', 'зач.', 'осв', 'отл', 'отч'];

    public function run($monitoringFile)
    {
        ini_set('memory_limit', '250M');

        $spreadsheet = IOFactory::load($monitoringFile);

        foreach ($spreadsheet->getAllSheets() as $workSheet) {
            $rowStopper = $this->getRowStopper($workSheet);
            $columnStopper = $this->getColumnStopper($workSheet);
            $this->processData($workSheet, $rowStopper, $columnStopper);
            break;
        }
    }

    private function processData($workSheet, $rowStopper, $columnStopper)
    {
        $studentIds = [];

        $groupName = $workSheet->getTitle();
        $groupId = $this->storeGroup($groupName);

        for ($column = $this->columnStarter; $column < $columnStopper; $column++) {

            $subjectName = $workSheet->getCell([$column, 14]);
            $subjectId = $this->storeSubject($subjectName);

            for ($row = $this->rowStarter; $row < $rowStopper; $row++) {
                if (!isset($studentIds[$row])) {
                    $studentName = $workSheet->getCell([3, $row]);
                    $studentIds[$row] = $this->storeStudent($studentName, $groupId);

                    $excused_hours = $workSheet->getCell([$columnStopper + 1, $row]);
                    $unexcused_hours = $workSheet->getCell([$columnStopper + 2, $row]);
//                    $this->storeAttendance($excused_hours, $unexcused_hours, $studentIds[$row]);
                }

                $grade = $workSheet->getCell([$column, $row])->getValue();
                $this->storeGrade($grade, $studentIds[$row], $subjectId);
            }
        }
    }

    private function getColumnStopper($sheet): int
    {
        return 8;
    }

    private function getRowStopper($sheet): int
    {
        return 30;
    }

    private function storeGroup(string $name): int
    {
        $group = Group::create([
            'name' => $name
        ]);

        return $group->id;
    }

    private function storeStudent(string $name, int $groupId): int
    {
        $student = Student::create([
            'name' => $name,
            'group_id' => $groupId
        ]);

        return $student->id;
    }

    private function storeSubject(string $name): int
    {
        $subject = Subject::create([
            'name' => $name
        ]);

        return $subject->id;
    }

    private function storeAttendance(int $excused_hours, int $unexcused_hours, int $studentId): void
    {
        Attendance::create([
            'excused_hours' => $excused_hours,
            'unexcused_hours' => $unexcused_hours,
            'student_ud' => $studentId
        ]);
    }

    private function storeGrade(string|array|null $grade, int $studentId, int $subjectId): void
    {
        $grade = $this->getGradeNum($grade);

        Grade::create([
            'grade' => $grade,
            'student_id' => $studentId,
            'subject_id' => $subjectId
        ]);
    }

    private function getGradeNum(string|array|null $grade): int
    {
        if (isString($grade)) {
            if (array_key_exists($grade, $this->gradeFiveKeywords)) {
                return 5;
            }
        }
        if ($grade <= 5 && $grade > 2) {
            return $grade;
        }

        return 2;
    }
}
