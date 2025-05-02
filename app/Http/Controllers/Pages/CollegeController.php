<?php

namespace App\Http\Controllers\Pages;

use App\Facades\PageData;
use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use App\Services\CollegeService;

class CollegeController extends Controller
{

    public function show(Monitoring $monitoring, CollegeService $service)
    {
        return view('pages.college')
            ->with(
                $service->getCollegePageData($monitoring)
            );
    }
}
