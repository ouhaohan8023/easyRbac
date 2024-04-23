<?php

namespace Ouhaohan8023\EasyRbac\Service;

use Ouhaohan8023\EasyRbac\Model\MenuHasPermission;

class MenuHasPermissionService
{
    public static function getPIdByMenus($menus)
    {
        return MenuHasPermission::query()->whereIn('menu_id', $menus)->pluck('permission_id');
    }
}
