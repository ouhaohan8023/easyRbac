<?php

namespace Ouhaohan8023\EasyRbac\Service;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;
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

        $permissionNames = config('easy-rbac.permissions');
        foreach ($routes as $route) {
            $name = $route->getName();
            if ($name) {
                $nameArr = explode('.', $name);
                if (in_array($nameArr[0], $gKeys)) {
                    $num = count($nameArr);
                    $rn = '';
                    $parent = null;
                    for ($i = 0; $i < $num; $i++) {
                        $add = [];
                        $rn .= $nameArr[$i];
                        $add['name'] = $rn;
                        $ex = Permission::query()->where('name', $rn)->first();
                        $title = false;
                        if (isset($permissionNames[$rn])) {
                            $title = $permissionNames[$rn];
                            $add['title'] = $title;
                        }
                        $rn .= '.';
                        if ($ex) {
                            $parent = $ex;
                            if ($title) {
                                $ex->title = $title;
                                $ex->save();
                            }

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
        // 更新了permission，删除缓存
        $cacheKey = config('easy-rbac.cache.permission', 'easy-rbac-permissions');
        Cache::forget($cacheKey);
    }

    public static function tree()
    {
        return Permission::get()->toTree();
    }

    public static function getPermissionsByUser(User $user)
    {
        $className = get_class($user);
        $userKey = 'user-permissions-'.$className.'-'.$user->id;
        $tagKey = config('easy-rbac.cache_tag.permission', 'easy-rbac-permission-tag');

        if (Cache::tags($tagKey)->has($userKey)) {
            return Cache::tags($tagKey)->get($userKey);
        }
        $superAdminKey = config('easy-rbac.super_admin_key', 'super_admin');
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole($superAdminKey)) {
                // 超管
                $permissions = Permission::query();
            } else {
                $permissions = $user->permissions();
            }
            $permissions = $permissions->select('name')->pluck('name');
            Cache::tags($tagKey)->rememberForever($userKey, function () use ($permissions) {
                return $permissions;
            });

            return $permissions;
        } else {
            // User对象没有hasRole方法
            throw new HasRoleException();
        }
    }

    /**
     * 将 permission 放入缓存
     * 用于中间件鉴别 permission 是否需要鉴权
     */
    public static function getCachedPermission()
    {
        $key = config('easy-rbac.cache.permission', 'easy-rbac-permissions');

        return Cache::rememberForever($key, function () {
            return Permission::all()->pluck('is_need_right', 'name')->toArray();
        });
    }

    /**
     * 通过tag清理所有的用户权限缓存
     *
     * @return void
     */
    public static function clearUserPermissionCache()
    {
        $tagKey = config('easy-rbac.cache_tag.permission', 'easy-rbac-permission-tag');
        Cache::tags($tagKey)->flush();
    }

    /**
     * 通过用户ID清理用户权限缓存
     *
     * @param  $id
     * @return void
     */
    public static function clearUserPermissionCacheByUser(User $user)
    {
        $className = get_class($user);
        $userKey = 'user-permissions-'.$className.'-'.$user->id;
        $tagKey = config('easy-rbac.cache_tag.permission', 'easy-rbac-permission-tag');
        Cache::tags($tagKey)->forget($userKey);
    }
}
