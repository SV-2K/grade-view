<?php

namespace App\Http\Controllers\Pages;

use App\Facades\PageData;
use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use App\Repositories\ChartsDataRepository;
use App\Repositories\GroupRepository;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct(
        private GroupRepository $groupRepository,
    )
    {}

    public function show(Request $request, Monitoring $monitoring)
    {
        $groupName = $request->input('name');
        $groupId = $this->groupRepository->getGroupId($monitoring->id, $groupName);

        if (is_null($groupName) || is_null($groupId)) {
            return view('pages.group')->with([
                'isEmpty' => true,
                'monitoring' => $monitoring
            ]);
        }

        return view('pages.group')
            ->with(
                PageData::getGroupPageData($monitoring, $groupName, $groupId)
            );
    }
}
