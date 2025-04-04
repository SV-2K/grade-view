<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Repositories\ChartsDataRepository;
use App\Repositories\GroupRepository;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct(
        private GroupRepository $groupRepository,
        private ChartsDataRepository $dataRepository
    )
    {}

    public function show(Request $request, Monitoring $monitoring)
    {
        $groupName = $request->input('name');

        if (is_null($groupName)) {
            return view('pages.group')->with([
                'isEmpty' => true,
                'monitoring' => $monitoring
            ]);
        }

        $groupId = $this->groupRepository->getGroupId($monitoring->id, $groupName);

        if (is_null($groupId)) {
            return redirect()->route('group');
        }

        $subjects = $this->dataRepository->getCategories('subjects', 'groups', $groupId);

        return view('pages.group')->with([
            'isEmpty' => false,
            'monitoring' => $monitoring,
            'group' => $request->input('name'),
            'averageGrade' => $this->groupRepository->getAverageGrade($groupId),
            'absolutePerformance' => $this->groupRepository->getAbsolutePerformance($groupId),
            'qualityPerformance' =>$this->groupRepository->getQualityPerformance($groupId),
            'studentsAmount' =>$this->groupRepository->getStudentsAmount($groupId),
            'gradesAmount' => $this->groupRepository->getGradesAmount($groupId),
            'grades' => $this->dataRepository->getGradesForEachCategory('groups', 'subjects', $groupId),
            'qualityPerformanceCategories' => $subjects,
            'gradeDistributionCategories' => $subjects,
            'gradesAmounts' => $this->dataRepository->getGradesAmounts('groups', $groupId),
            'attendance' => $this->dataRepository->getAttendance($groupId),
            'performance' => $this->dataRepository->getQualityPerformance($groupId),
        ]);
    }
}
