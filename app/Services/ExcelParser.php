<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelParser
{
    public function run($monitoringFile)
    {
        ini_set('memory_limit', '250M');

        $spreadsheet = IOFactory::load($monitoringFile);


        dd($spreadsheet->getSheetCount());
    }
}
