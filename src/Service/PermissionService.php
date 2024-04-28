<?php

namespace Ouhaohan8023\EasyRbac\Service;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;
use Ouhaohan8023\EasyRbac\Exception\HasRoleException;
use Ouhaohan8023\EasyRbac\Model\Permission;

class PermissionService
{
    /**
     * 将路由同步按照树状结构同步到表中
     *
     * @return void
     */
    public static function sync()
    {
        $sAdmin = RoleService::findSuperAdmin();
        $routes = Route::getRoutes();
        $groups = config('easy-rbac.groups');
        $gKeys = array_keys($groups);
        $newIds = [];

        foreach ($routes as $route) {
            $name = $route->getName();
            if ($name) {
                $nameArr = explode('.', $name);
                if (in_array($nameArr[0], $gKeys)) {
                    $num = count($nameArr);
                    $rn = '';
                    $parent = null;
                    for ($i = 0; $i < $num; $i++) {
                        $rn .= $nameArr[$i];
                        $add['name'] = $rn;
                        $ex = Permission::query()->where('name', $rn)->first();
                        $rn .= '.';
                        if ($ex) {
                            $parent = $ex;

                            continue;
                        }
                        $add['guard_name'] = 'api';
                        if ($parent) {
                            $add['parent_id'] = $parent->id;
                        }
                        $parent = Permission::create($add);
                        $newIds[] = $parent->id;
                    }
                }

            }
        }
        $sAdmin->givePermissionTo($newIds);
    }

    public static function tree()
    {
        return Permission::get()->toTree();
    }

    public static function getPermissionsByUser(User $user)
    {
        $key = config('easy-rbac.super_admin_key', 'super_admin');
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole($key)) {
                // 超管
                $permissions = Permission::query();
            } else {
                $permissions = $user->permissions();
            }
            return $permissions->select('name')->pluck('name');
        } else {
            // User对象没有hasRole方法
            throw new HasRoleException();
        }

    }
}
