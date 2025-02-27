<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelParser
{
    private int $rowStarter = 17;
    private int $columnStarter = 4;

    public function run($monitoringFile)
    {
        ini_set('memory_limit', '250M');

        $spreadsheet = IOFactory::load($monitoringFile);

        foreach ($spreadsheet->getAllSheets() as $workSheet) {
            $rowStopper = $this->getRowStopper($workSheet);
            $columnStopper = $this->getColumnStopper($workSheet);
            $this->processData($workSheet, $rowStopper, $columnStopper);
        }
    }

    private function processData($workSheet, $rowStopper, $columnStopper)
    {
        $subjectIds = [];

        $groupName = $workSheet->getTitle();
        $groupId = $this->storeGroup($groupName);

        for ($row = $this->rowStarter; $row < $rowStopper; $row++) {

            $studentName = $workSheet->getCell([3, $row]);
            $studentId = $this->storeStudent($studentName, $groupId);

            $validAbsenceHours = $workSheet->getCell([$row, $columnStopper + 1]);
            $invalidAbsenceHours = $workSheet->getCell([$row, $columnStopper + 2]);
            $this->storeAttendance($validAbsenceHours, $invalidAbsenceHours, $studentId);

            for ($column = $this->columnStarter; $column < $columnStopper; $column++) {
                if (!isset($subjectIds[$column])) {
                    $subjectName = $workSheet->getCell([14, $column]);
                    $subjectIds[$column] = $this->storeSubject($subjectName);
                }

                $grade = $workSheet->getCell([$row, $column]);
                $this->storeGrade($grade, $studentId, $subjectIds[$column]);
            }
        }
    }

    private function getColumnStopper($sheet)
    {
        ///
    }

    private function getRowStopper($sheet)
    {
        ///
    }

    private function storeGroup($name)
    {

    }

    private function storeStudent($student, $groupId)
    {

    }

    private function storeSubject($subject)
    {

    }

    private function storeAttendance($validAttendance, $invalidAttendance, $studentId)
    {

    }

    private function storeGrade($grade, $studentId, $subjectId)
    {

    }

}
