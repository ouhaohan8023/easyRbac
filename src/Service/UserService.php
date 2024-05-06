<?php

namespace Ouhaohan8023\EasyRbac\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ouhaohan8023\EasyRbac\Model\Role;

class UserService
{
    /**
     * 修改角色之后，要同步所有包含这个角色的用户的权限
     * 单个角色
     *
     * @param  $role  Role
     * @return false|mixed
     */
    public static function updateUserRolePermission(Role $role)
    {
        $models = config('easy-rbac.users');
        $permissions = $role->permissions()->pluck('id')->flatten()->toArray();
        DB::beginTransaction();
        try {
            // 更新角色后，要同步更新用户的权限
            foreach ($models as $model) {
                $users = $model::whereHas('roles', function ($query) use ($role) {
                    $query->where('id', $role->id);
                })->get();
                foreach ($users as $user) {
                    $user->syncPermissions($permissions);
                    // 清理用户的权限缓存
                    PermissionService::clearUserPermissionCacheByUser($user);
                }
            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error('更新用户包含的权限失败', ['msg' => $e->getMessage()]);
            DB::rollBack();

            return false;
        }
    }
}
