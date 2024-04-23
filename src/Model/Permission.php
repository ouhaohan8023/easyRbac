<?php

namespace Ouhaohan8023\EasyRbac\Model;

use Illuminate\Support\Facades\Route;
use Kalnoy\Nestedset\NodeTrait;

class Permission extends \Spatie\Permission\Models\Permission
{
    use NodeTrait;

    protected $fillable = [
        "id",
        "name",
        "title",
        "guard_name",
        "weigh",
        "state",
        "is_need_login",
        "is_need_right",
        "parent_id",
    ];

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
