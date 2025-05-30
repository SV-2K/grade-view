<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\Grade;

class ExcelParser
{
    private int $rowStarter = 17;
    private int $columnStarter = 4;
    private bool $isSeparated; #some monitorings have the subject and teacher name separated, and some have them in one cell

    # Все те слова, которые будут считаться за оценку 5
    private array $gradeFiveKeywords = ['зач', 'зач.', 'осв', 'отл', 'отч'];

    public function run(array $filePaths, int $monitoringId): void
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 120);

        foreach ($filePaths as $path) {
            $reader = IOFactory::createReaderForFile($path);
            $reader->setReadDataOnly(true);

            $spreadsheet = $reader->load($path);

            foreach ($spreadsheet->getAllSheets() as $workSheet) {
                $this->isSeparated = $this->isSubjInfoSeparated($workSheet);

                $rowStopper = $this->getRowStopper($workSheet);
                $columnStopper = $this->getColumnStopper($workSheet);
                $this->processData($monitoringId, $workSheet, $rowStopper, $columnStopper);
            }
        }
    }

    private function processData(int $monitoringId, $workSheet, int $rowStopper, int $columnStopper): void
    {
        $studentIds = [];

        $groupName = $workSheet->getTitle();
        $groupId = $this->storeGroup($groupName, $monitoringId);

        for ($column = $this->columnStarter; $column < $columnStopper; $column++) {

            if ($this->isSeparated) {
                $subjectName = $workSheet->getCell([$column, 13])->getValue();
                $teacherName = $workSheet->getCell([$column, 14])->getValue();
            } else {
                $cell = $workSheet->getCell([$column, 14])->getValue();
                $subjectName = $this->getSubject($cell);
                $teacherName = $this->getTeacher($cell);
            }
            $subjectId = $this->storeSubject($subjectName, $teacherName, $monitoringId);

            for ($row = $this->rowStarter; $row < $rowStopper; $row++) {
                if (!isset($studentIds[$row])) {
                    $studentName = $workSheet->getCell([3, $row])->getValue();
                    $studentIds[$row] = $this->storeStudent($studentName, $groupId);

                    $excused_hours = $workSheet->getCell([$columnStopper + 1, $row])->getValue();
                    $unexcused_hours = $workSheet->getCell([$columnStopper + 2, $row])->getValue();
                    $this->storeAttendance($excused_hours, $unexcused_hours, $studentIds[$row]);
                }

                $grade = $workSheet->getCell([$column, $row])->getValue();
                $this->storeGrade($grade, $studentIds[$row], $subjectId);
            }
        }
    }

    private function getColumnStopper($sheet): int
    {
        for ($column = $this->columnStarter; $column < 20; $column++) {

            $cell = $sheet->getCell([$column, 14])->getValue();

            if ($cell === NULL || str_contains($cell, 'Всего')) {
                $columnStopper = $column;
                break;
            }
        }
        return $columnStopper;
    }

    private function getRowStopper($sheet): int
    {
        for ($row = $this->rowStarter; $row < 50; $row++) {

            $cell = $sheet->getCell([3, $row])->getValue();

            if ($cell === NULL || $cell === 'Средний балл') {
                $rowStopper = $row;
                break;
            }
        }
        return $rowStopper;
    }

    private function isSubjInfoSeparated($sheet): bool
    {
        $cell = $sheet->getCell('D13')->getValue();

        if ($cell === null || str_contains($cell, 'Наименование дисциплины')) {
            return false;
        }
        return true;
    }

    private function storeGroup(string $name, int $monitoringId): int
    {
        $group = Group::create([
            'name' => $name,
            'monitoring_id' => $monitoringId,
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

    private function storeSubject(string $name, string $teacher_name, int $monitoringId): int
    {
        $subjectId = $this->getSubjectId($name, $monitoringId);

        if (NULL == $subjectId) {
            $subject = Subject::create([
                'name' => $name,
                'teacher_name' => $teacher_name,
                'monitoring_id' => $monitoringId
            ]);

            return $subject->id;
        }
        return $subjectId;
    }

    private function storeAttendance(int|string|null $excused_hours, int|string|null $unexcused_hours, int $studentId): void
    {
        $excused_hours = $this->getAttendanceNum($excused_hours);
        $unexcused_hours = $this->getAttendanceNum($unexcused_hours);

        Attendance::create([
            'excused_hours' => $excused_hours,
            'unexcused_hours' => $unexcused_hours,
            'student_id' => $studentId
        ]);
    }

    private function storeGrade(string|null $grade, int $studentId, int $subjectId): void
    {
        $grade = $this->getGradeNum($grade);

        Grade::create([
            'grade' => $grade,
            'student_id' => $studentId,
            'subject_id' => $subjectId
        ]);
    }

    private function getGradeNum(string|null $grade): int
    {

        if ($grade <= 5 && $grade > 2) {
            return $grade;
        }

        if (in_array($grade, $this->gradeFiveKeywords)) {
            return 5;
        }

        return 2;
    }

    private function getAttendanceNum(int|string|null $attendance): int
    {
        if (is_string($attendance)) {
            return 0;
        }
        return $attendance ?? 0;
    }

    private function getSubjectId(string $name, int $monitoringId): int|null
    {
        if (Subject::whereName($name)->whereMonitoringId($monitoringId)->exists()) {
            return Subject::whereName($name)->whereMonitoringId($monitoringId)->first()->id;
        }
        return NULL;
    }

    private function getSubject(string $string): string
    {
        $length = strpos($string, '(');
        return trim(substr($string, 0, $length));
    }

    private function getTeacher(string $string): string
    {
        return trim(substr($string, strpos($string, '(')), '(\)');
    }
}
