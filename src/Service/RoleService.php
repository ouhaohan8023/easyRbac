<?php

namespace Ouhaohan8023\EasyRbac\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ouhaohan8023\EasyRbac\Model\Role;

class RoleService
{
    /**
     * 建立超管角色
     */
    public static function findSuperAdmin()
    {
        return Role::query()->firstOrCreate([
            'name' => 'super_admin',
            'title' => '超级管理员',
            'guard_name' => 'api',
        ]);
    }

    public static function add($data)
    {
        DB::beginTransaction();
        try {
            $data['guard_name'] = $data['guard_name'] ?? 'api';
            $role = Role::create($data);
            if (isset($data['menus']) && $data['menus']) {
                // 角色绑定菜单
                $role->menus()->sync($data['menus']);
                // 角色绑定菜单对应的权限（路由）
                $permissionIds = MenuHasPermissionService::getPIdByMenus($data['menus']);
                $role->syncPermissions($permissionIds);
            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error('新增角色失败', ['msg' => $e->getMessage()]);
            DB::rollBack();

            return false;
        }
    }

    public static function update($data, $id)
    {
        DB::beginTransaction();
        try {
            $role = Role::find($id);
            if (! $role) {
                throw new \Exception('Menu not found');
            }

            $role->fill($data)->save();

            if (isset($data['menus']) && $data['menus']) {
                $role->menus()->sync($data['menus']);
                $permissionIds = MenuHasPermissionService::getPIdByMenus($data['menus']);
                $role->syncPermissions($permissionIds);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error('更新角色失败', ['msg' => $e->getMessage()]);
            DB::rollBack();

            return false;
        }
    }

    public static function tree()
    {
        return Role::get()->toTree();

    }
}
