<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function show(Request $request)
    {
        $subjectName = $request->input('name');

        if(is_null($subjectName)) {
            return view('pages.subject')->with('isEmpty', true);
        }

        $subjectId = $this->getSubjectId($subjectName);

        return view('pages.subject')->with([
            'isEmpty' => false,
            'subject' => $subjectName,
            'categories' => $this->getGroups(),
            'grades' => $this->getGrades(),
            'averageGrades' => $this->getAverageGrades(),
            'gradesAmount' => $this->getGradesAmount(),
        ]);
    }

    private function getSubjectId(string $subjectName): int
    {
        $subjectId = Subject::where('name', $subjectName)
            ->value('id');

        return $subjectId;
    }

    private function getGroups(): array
    {
        return ['9СЫС-33.3', '4DD-4.12', 'AB0-B223', 'АБВ-1.23'];
    }

    private function getGrades(): array
    {
        return [
            ['5', 12, 11, 7, 4],
            ['4', 1, 10, 12, 9],
            ['3', 2, 4, 3, 5],
            ['2', 10, 0, 3, 7]
        ];
    }

    private function getAverageGrades():array
    {
        return ['', 4.5, 3.76, 3.6, 3];
    }

    private function getGradesAmount(): array
    {
        return [
            ['5', 23],
            ['4', 20],
            ['3', 10],
            ['2', 14]
        ];
    }
}
