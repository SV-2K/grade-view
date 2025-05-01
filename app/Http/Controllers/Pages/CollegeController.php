<?php

namespace App\Http\Controllers\Pages;

use App\Facades\PageData;
use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use App\Repositories\ChartsDataRepository;
use App\Repositories\CollegeRepository;

class CollegeController extends Controller
{

    public function show(Monitoring $monitoring)
    {
        return view('pages.college')
            ->with(
                PageData::getCollegePageData($monitoring)
            );
    }
}
