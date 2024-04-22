<?php

namespace Ouhaohan8023\EasyRbac\Model;

use Illuminate\Support\Facades\Route;
use Kalnoy\Nestedset\NodeTrait;

class Permission extends \Spatie\Permission\Models\Permission
{
    use NodeTrait;

    /**
     * 将路由同步按照树状结构同步到表中
     */
    public static function sync()
    {
        // find super_admin
//        $routes = Route::getRoutes();
//        $groups = config('easy-rbac.groups');
//        $gKeys = array_keys($groups);
    }
}
