<?php
/*
 * Copyright (c) 2024. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace Ouhaohan8023\EasyRbac\Model;

use Ouhaohan8023\EasyRbac\Service\MenuService;
use Ouhaohan8023\EasyRbac\Service\PermissionService;
use Ouhaohan8023\EasyRbac\Service\RoleService;

class EasyRbac
{
    public static function syncPermission()
    {
        PermissionService::sync();
    }

    public static function permissionTree()
    {
        return PermissionService::tree();
    }

    public static function initMenus($strings)
    {
        $arr = json_decode($strings, true);
        MenuService::init($arr);
    }

    public static function addMenu($data)
    {
        return MenuService::add($data);
    }

    public static function updateMenu($data, $id)
    {
        return MenuService::update($data, $id);
    }

    public static function menuTree()
    {
        return MenuService::tree();
    }

    public static function roleTree()
    {
        return RoleService::tree();
    }

    public static function addRole($data)
    {
        return RoleService::add($data);
    }

    public static function updateRole($data, $id)
    {
        return RoleService::update($data, $id);
    }
}
