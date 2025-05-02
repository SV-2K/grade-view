<?php

namespace App\Services;

use App\Models\Monitoring;
use App\Repositories\ChartsDataRepository;
use App\Repositories\Group\GroupStatsRepository;
use App\Repositories\SubjectRepository;

class PageDataService
{
    public function __construct(
        private ChartsDataRepository $dataRepository,
        private SubjectRepository    $subjectRepository,
    )
    {}

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
