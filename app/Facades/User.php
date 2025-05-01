<?php

namespace App\Facades;

use App\Services\UserService;
use Illuminate\Support\Facades\Facade;

/**
 * @see UserService
 *
 * @method static array getMonitorings()
 * @method static bool auth(array $data)
 */
class User extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'user_service';
    }
}
