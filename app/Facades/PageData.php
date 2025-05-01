<?php

namespace App\Facades;

use App\Models\Monitoring;
use App\Services\PageDataService;
use Illuminate\Support\Facades\Facade;

/**
 * @see PageDataService
 *
 * @method static array getCollegePageData(Monitoring $monitoring)
 * @method static array getGroupPageData(Monitoring $monitoring, string $groupName, int $groupId)
 * @method static array getSubjectPageData(Monitoring $monitoring, string $subjectName, int $subjectId)
 */

class PageData extends Facade
{
    protected static function getFacadeAccessor():string
    {
        return 'page_data_service';
    }
}
