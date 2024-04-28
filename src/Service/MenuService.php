<?php

namespace Ouhaohan8023\EasyRbac\Service;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ouhaohan8023\EasyRbac\Exception\HasRoleException;
use Ouhaohan8023\EasyRbac\Model\Menu;
use Ouhaohan8023\EasyRbac\Model\RoleHasMenu;

class MenuService
{
    /**
     * 同步菜单
     */
    public static function init($menus, $pid = null)
    {
        foreach ($menus as $menu) {
            $add = [];
            $add['name'] = $menu['name'];
            if (isset($menu['meta'])) {
                $keys = [
                    'title', 'icon', 'noColumn', 'noClosable', 'hidden', 'breadcrumbHidden', 'levelHidden', 'fullscreen'
                ];

                foreach ($keys as $key) {
                    if (isset($menu['meta'][$key])) {
                        $add[$key] = $menu['meta'][$key];
                    }
                }
            }
            if (isset($menu['path'])) {
                $add['path'] = $menu['path'];
            }
            if ($pid) {
                $add['parent_id'] = $pid;
            }

            $parent = Menu::create($add);
            if (isset($menu['children'])) {
                self::init($menu['children'], $parent->id);
            }
        }
    }

    public static function add($data)
    {
        DB::beginTransaction();
        try {
            $menu = Menu::create($data);
            if (isset($data['guard']) && $data['guard']) {
                $menu->permissions()->sync($data['guard']);
            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error('新增菜单失败', ['msg' => $e->getMessage()]);
            DB::rollBack();

            return false;
        }
    }

    public static function update($data, $id)
    {
        DB::beginTransaction();
        try {
            $menu = Menu::find($id);
            if (!$menu) {
                throw new \Exception('Menu not found');
            }

            $menu->fill($data)->save();

            if (isset($data['guard']) && $data['guard']) {
                $menu->permissions()->sync($data['guard']);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error('更新菜单失败', ['msg' => $e->getMessage()]);
            DB::rollBack();

            return false;
        }
    }

    public static function tree()
    {
        return Menu::get()->toTree();

    }

    public static function getMenusByUser(User $user)
    {
        $key = config('easy-rbac.super_admin_key', 'super_admin');
        $menus = Menu::query();
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole($key)) {
                // 超管
            } else {
                $m = RoleHasMenu::query()
                    ->select('menu_id')
                    ->whereIn('role_id', $user->roles->pluck('id'))
                    ->distinct()
                    ->pluck('menu_id');
                $menus->whereIn('id', $m)->whereIn('type', ['directory', 'menu']);
            }
            return $menus->get()->toTree();
        } else {
            // User对象没有hasRole方法
            throw new HasRoleException();
        }

    }

    /**
     * 把菜单数据持久化到本地
     * @return void
     */
    public static function persistence()
    {
        $path = config('easy-rbac.menus', 'menus.json');

        $menus = Menu::query()
            ->select('id', 'name', 'path', 'component', 'redirect', 'hidden', 'levelHidden', 'title', 'icon', 'isCustomSvg',
                'noKeepAlive', 'noClosable', 'noColumn', 'badge', 'tabHidden', 'activeMenu', 'dot', 'dynamicNewTab',
                'breadcrumbHidden', 'fullscreen', 'system', 'weigh', 'img', 'type', 'parent_id')
            ->get()->toArray();
        $json = json_encode($menus, JSON_UNESCAPED_SLASHES);
        Storage::put($path, $json);
    }

    public static function restore()
    {
        $path = config('easy-rbac.menus', 'menus.json');
        $json = Storage::get($path);
        $menus = json_decode($json, true);
        foreach ($menus as $menu) {
            Menu::updateOrCreate(['id' => $menu['id']], $menu);
        }

    }
}
