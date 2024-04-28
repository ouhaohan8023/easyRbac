<?php

namespace Ouhaohan8023\EasyRbac\Request;

class MenuRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'parent_id' => 'bail|integer|exists:menus,id',
            'name' => ['max:255'],
            'path' => 'max:255',
            'component' => 'max:255',
            'redirect' => 'max:255',
            'hidden' => 'integer',
            'levelHidden' => 'integer',
            'title' => 'required|max:255',
            'icon' => 'max:64',
            'isCustomSvg' => 'integer',
            'noKeepAlive' => 'integer',
            'noClosable' => 'integer',
            'noColumn' => 'integer',
            'badge' => 'max:128',
            'tabHidden' => 'integer',
            'activeMenu' => 'max:256',
            'dot' => 'integer',
            'dynamicNewTab' => 'integer',
            'breadcrumbHidden' => 'integer',
            'weight' => 'integer',
            'img' => 'max:256',
            'type' => 'required|string|in:directory,menu,button',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function attributes()
    {
        return [
            'name' => '名称',
            'path' => 'PATH',
            'component' => '文件路径',
            'redirect' => '重定向',
            'hidden' => '是否显示在菜单中显示路由',
            'levelHidden' => '是否显示在菜单中显示隐藏一级路由',
            'title' => '菜单、面包屑、多标签页显示的名称',
            'icon' => '菜单图标',
            'isCustomSvg' => '是否自定义SVG图标',
            'noKeepAlive' => '当前路由是否不缓存',
            'noClosable' => '当前路由是否可关闭多标签页',
            'noColumn' => '当前路由是否可关闭多标签页',
            'badge' => 'badge小标签',
            'tabHidden' => '当前路由是否不显示多标签页',
            'activeMenu' => '高亮指定菜单，要从跟路由的path开始拼接',
            'dot' => '小红点标记',
            'dynamicNewTab' => '是否详情页根据id传参不同可打开多个',
            'breadcrumbHidden' => '是否隐藏面包屑',
            'weight' => '权重',
            'img' => '菜单封面',
            'type' => '类型：directory目录、menu菜单、button按钮',
            'system' => '系统',
        ];
    }
}
