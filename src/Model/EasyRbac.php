<?php
/*
 * Copyright (c) 2024. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace Ouhaohan8023\EasyRbac\Model;

use Illuminate\Foundation\Auth\User;
use Ouhaohan8023\EasyRbac\Service\MenuService;
use Ouhaohan8023\EasyRbac\Service\PermissionService;
use Ouhaohan8023\EasyRbac\Service\RoleService;

class EasyRbac
{
    /**
     * 同步后端权限
     *
     * @return void
     */
    public static function syncPermission()
    {
        PermissionService::sync();
    }

    /**
     * 返回权限树
     *
     * @return mixed
     */
    public static function permissionTree($name = "")
    {
        return PermissionService::tree($name);
    }

    /**
     * 使用前端路由初始化菜单
     *
     * @return void
     */
    public static function initMenus($strings)
    {
        $arr = json_decode($strings, true);
        MenuService::init($arr);
    }

    /**
     * 新增菜单
     *
     * @return bool
     */
    public static function addMenu($data)
    {
        return MenuService::add($data);
    }

    /**
     * 更新菜单
     *
     * @return bool
     */
    public static function updateMenu($data, $id)
    {
        return MenuService::update($data, $id);
    }

    /**
     * 菜单树
     *
     * @return mixed
     */
    public static function menuTree()
    {
        return MenuService::tree();
    }

    /**
     * 角色树
     *
     * @return mixed
     */
    public static function roleTree()
    {
        return RoleService::tree();
    }

    /**
     * 新增角色
     *
     * @return bool
     */
    public static function addRole($data)
    {
        return RoleService::add($data);
    }

    /**
     * 更新角色
     *
     * @return bool
     */
    public static function updateRole($data, $id)
    {
        return RoleService::update($data, $id);
    }

    /**
     * 获取用户的可用菜单树
     *
     * @return mixed
     *
     * @throws \Ouhaohan8023\EasyRbac\Exception\HasRoleException
     */
    public static function getMenusByUser(User $user)
    {
        return MenuService::getMenusByUser($user);
    }

    /**
     * 获取用户的可用权限列表
     *
     * @return \Illuminate\Support\Collection
     *
     * @throws \Ouhaohan8023\EasyRbac\Exception\HasRoleException
     */
    public static function getPermissionsByUser(User $user)
    {
        return PermissionService::getPermissionsByUser($user);
    }

    /**
     * 将menus表的数据持久化到本地
     *
     * @return void
     */
    public static function persistenceMenus()
    {
        MenuService::persistence();
    }

    /**
     * 将本地持久化的menus数据恢复到数据库
     *
     * @return void
     */
    public static function restoreMenus()
    {
        MenuService::restore();
    }

    /**
     * 删除菜单
     * 有子节点的话无法直接删除
     *
     * @return bool
     */
    public static function delMenu($id, $children = false)
    {
        MenuService::del($id, $children);
    }
}
