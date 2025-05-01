<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
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

    public function show(Request $request, Monitoring $monitoring)
    {
        $subjectName = $request->input('name');

        if (is_null($subjectName)) {
            return view('pages.subject')->with([
                'isEmpty' => true,
                'monitoring' => $monitoring
            ]);
        }

        $subjectId = $this->subjectRepository->getSubjectId($subjectName);

        if (is_null($subjectId)) {
            return redirect()->route('subject');
        }

        $groups = $this->dataRepository->getCategories('groups', 'subjects', $subjectId);

        return view('pages.subject')->with([
            'isEmpty' => false,
            'monitoring' => $monitoring,
            'subject' => $subjectName,
            'averageGrade' => $this->subjectRepository->getAverageGrade($subjectId),
            'groupsAmount' => $this->subjectRepository->getGroupsAmount($subjectId),
            'absolutePerformance' => $this->subjectRepository->getAbsolutePerformance($subjectId),
            'qualityPerformance' =>$this->subjectRepository->getQualityPerformance($subjectId),
            'studentsAmount' =>$this->subjectRepository->getStudentsAmount($subjectId),
            'gradeDistributionCategories' => $groups,
            'averageGradesCategories' => $groups,
            'grades' => $this->dataRepository->getGradesForEachCategory('subjects', 'groups',$subjectId),
            'averageGrades' => $this->dataRepository->getAverageGrades('groups', 'subjects', $subjectId),
            'gradesAmounts' => $this->dataRepository->getGradesAmounts('subjects', $subjectId),
        ]);
    }
}
