<?php

namespace Ouhaohan8023\EasyRbac\Service;

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
            'guard_name' => 'api'
        ]);
    }

    public static function add()
    {

    }
}
