<?php

namespace App\Http\Controllers;

use App\Repositories\ChartsDataRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct(
        private ChartsDataRepository $dataRepository,
        private SubjectRepository $subjectRepository
    )
    {}

    public function show(Request $request)
    {
        $subjectName = $request->input('name');

        if(is_null($subjectName)) {
            return view('pages.subject')->with('isEmpty', true);
        }

        $subjectId = $this->dataRepository->getSubjectId($subjectName);

        return view('pages.subject')->with([
            'isEmpty' => false,
            'subject' => $subjectName,
            'averageGrade' => $this->subjectRepository->getAverageGrade($subjectId),
            'groupsAmount' => $this->subjectRepository->getGroupsAmount($subjectId),
            'absolutePerformance' => $this->subjectRepository->getAbsolutePerformance($subjectId),
            'qualityPerformance' =>$this->subjectRepository->getQualityPerformance($subjectId),
            'studentsAmount' =>$this->subjectRepository->getStudentsAmount($subjectId),
            'categories' => $this->dataRepository->getGroups($subjectId),
            'grades' => $this->dataRepository->getGradesForEachGroup($subjectId),
            'averageGrades' => $this->dataRepository->getAverageGrades($subjectId),
            'gradesAmount' => $this->dataRepository->getGradesAmount($subjectId),
        ]);
    }
}
