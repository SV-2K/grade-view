<?php

namespace App\Http\Controllers;

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

    public function show(Request $request)
    {
        $groupName = $request->input('name');

        if (is_null($groupName)) {
            return view('pages.group')->with(['isEmpty' => true]);
        }

        $groupId = $this->groupRepository->getGroupId($groupName);

        return view('pages.group')->with([
            'isEmpty' => false,
            'group' => $request->input('name'),
            'averageGrade' => $this->groupRepository->getAverageGrade($groupId),
            'absolutePerformance' => $this->groupRepository->getAbsolutePerformance($groupId),
            'qualityPerformance' =>$this->groupRepository->getQualityPerformance($groupId),
            'studentsAmount' =>$this->groupRepository->getStudentsAmount($groupId),
            'grades' => $this->dataRepository->getGradesForEachCategory('groups', 'subjects', $groupId),
            'categories' => $this->dataRepository->getCategories('groups', 'subjects', $groupId),
            'gradesAmount' => $this->dataRepository->getGradesAmount('groups', $groupId),
            'attendance' => $this->dataRepository->getAttendance($groupId),
            'performance' => $this->dataRepository->getQualityPerformance($groupId)
        ]);
    }
}
