<?php

namespace Ouhaohan8023\EasyRbac\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ouhaohan8023\EasyRbac\Model\Menu;

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
                if (isset($menu['meta']['title'])) {
                    $add['title'] = $menu['meta']['title'];
                }
                if (isset($menu['meta']['icon'])) {
                    $add['icon'] = $menu['meta']['icon'];
                }
                if (isset($menu['meta']['noClosable'])) {
                    $add['noClosable'] = $menu['meta']['noClosable'];
                }
                if (isset($menu['meta']['hidden'])) {
                    $add['state'] = $menu['meta']['hidden'];
                }
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
            Log::error("新增菜单失败", ['msg' => $e->getMessage()]);
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
            Log::error("更新菜单失败", ['msg' => $e->getMessage()]);
            DB::rollBack();
            return false;
        }
    }

    public static function tree()
    {
        return Menu::get()->toTree();

    }
}
