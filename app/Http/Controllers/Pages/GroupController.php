<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use App\Repositories\Group\GroupStatsRepository;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function show(
        Request $request,
        Monitoring $monitoring,
        GroupStatsRepository $statsRepository,
        GroupService $service
    ): View
    {
        $groupName = $request->input('name');
        $groupId = $statsRepository->getGroupId($monitoring->id, $groupName);

        if (is_null($groupName) || is_null($groupId)) {
            return view('pages.group')->with([
                'isEmpty' => true,
                'monitoring' => $monitoring,
                'sideMenuStats' => [
                    'errorMessage' => 'Выберите группу...'
                ]
            ]);
        }

        return view('pages.group')
            ->with(
                $service->getGroupPageData($monitoring, $groupName, $groupId)
            );
    }
}
