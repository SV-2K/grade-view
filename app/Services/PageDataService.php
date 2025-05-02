<?php

namespace App\Services;

use App\Models\Monitoring;
use App\Repositories\ChartsDataRepository;
use App\Repositories\College\CollegeStatsRepository;
use App\Repositories\GroupRepository;
use App\Repositories\SubjectRepository;

class PageDataService
{
    public function __construct(
        private ChartsDataRepository   $dataRepository,
        private GroupRepository        $groupRepository,
        private SubjectRepository      $subjectRepository,
    )
    {}

    public function getGroupPageData(Monitoring $monitoring, string $groupName, int $groupId): array
    {
        $subjects = $this->dataRepository->getCategories('subjects', 'groups', $groupId);

        return [
            'isEmpty' => false,
            'monitoring' => $monitoring,
            'group' => $groupName,
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
        ];
    }

    public function getSubjectPageData(Monitoring $monitoring, string $subjectName, int $subjectId): array
    {
        $groups = $this->dataRepository->getCategories('groups', 'subjects', $subjectId);

        return [
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
        ];
    }
}
