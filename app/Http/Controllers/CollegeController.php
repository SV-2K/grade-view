<?php

namespace App\Http\Controllers;

use App\Repositories\ChartsDataRepository;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function __construct(
        private ChartsDataRepository $dataRepository
    )
    {}

    public function show()
    {
        return view('pages.college')->with([
            'performance' => $this->dataRepository->getQualityPerformance()
        ]);
    }
}
