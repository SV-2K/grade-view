<?php

namespace App\Services;

use App\Models\Monitoring;
use App\Repositories\Subject\SubjectChartRepository;
use App\Repositories\Subject\SubjectStatsRepository;

class SubjectService
{
    private SubjectStatsRepository $statsRepository;
    private SubjectChartRepository $chartRepository;

    public function __construct()
    {
        $this->statsRepository = new SubjectStatsRepository();
        $this->chartRepository = new SubjectChartRepository();
    }

    public function getSubjectPageData(
        Monitoring  $monitoring,
        string      $subjectName,
        int         $subjectId
    ): array
    {
        $this->statsRepository->setSubjectId($subjectId);
        $this->chartRepository->setSubjectId($subjectId);

        return [
            'isEmpty' => false,
            'monitoring' => $monitoring,
            'subject' => $subjectName,
            'averageGrade' => $this->statsRepository->getAverageGrade(),
            'groupsAmount' => $this->statsRepository->getGroupsAmount(),
            'absolutePerformance' => $this->statsRepository->getAbsolutePerformance(),
            'qualityPerformance' => $this->statsRepository->getQualityPerformance(),
            'studentsAmount' => $this->statsRepository->getStudentsAmount(),
            'averageGradesData' => $this->getAverageGradesData(),
            'gradeDistributionData' => $this->getGradeDistributionData(),
            'gradesRatioData' => $this->getGradesRatioData()
        ];
    }

    private function getAverageGradesData(): array
    {
        $collection = $this->chartRepository->getAverageGrades()
            ->sortBy('average_grade');

        $averageGrades = [''];
        $groupNames = [];

        foreach ($collection as $item) {
            $averageGrades[] = $item->average_grade;
            $groupNames[] = $item->group_name;
        }

        return [
            'averageGrades' => $averageGrades,
            'groupNames' => $groupNames
        ];
    }

    private function getGradesRatioData(): array
    {
        $gradesRatio = $this->chartRepository->getGradesRatio();

        return [
            ['5', $gradesRatio->grade_5],
            ['4', $gradesRatio->grade_4],
            ['3', $gradesRatio->grade_3],
            ['2', $gradesRatio->grade_2]
        ];
    }

    private function getGradeDistributionData(): array
    {
        $collection = $this->chartRepository->getGradeDistribution()
            ->sortBy(['grade_5', 'grade_4', 'grade_3', 'grade_2']);

        $groups = [];
        $grades = [
            ['5'], ['4'], ['3'], ['2']
        ];

        foreach ($collection as $item) {
            $groups[] = $item->group_name;
            $grades[0][] = $item->grade_5;
            $grades[1][] = $item->grade_4;
            $grades[2][] = $item->grade_3;
            $grades[3][] = $item->grade_2;
        }

        return [
            'grades' => $grades,
            'categories' => $groups
        ];
    }
}
