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
            'system' => 'required|max:64',
            'name' => ['max:255'],
            'title' => 'required|max:255',
            'url' => 'max:255',
            'file_path' => 'max:255',
            'redirection' => 'max:255',
            'icon' => 'max:64',
            'badge' => 'max:128',
            'activeMenu' => 'max:128',

            'dot' => 'integer',
            'state' => 'integer',
            'isSvg' => 'integer',
            'levelHidden' => 'integer',
            'noClosable' => 'integer',
            'breadcrumbHidden' => 'integer',
            'hidden' => 'integer',
            'dynamicNewTab' => 'integer',

            'weigh' => 'integer',
            'extend' => 'array',

            'guard' => 'nullable|array',
            'img' => 'nullable|string|max:256',
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
            'system' => '所属系统',
            'parent_id' => '所属菜单',
            'name' => 'name',
            'title' => '标题',
            'url' => '路径',
            'file_path' => '文件路径',
            'redirection' => '重定向',
            'icon' => '图标',
            'badge' => '徽章',
            'activeMenu' => '活动页',

            'isSvg' => '是否自定义svg图标',
            'dot' => '小红点',
            'state' => '状态',
            'levelHidden' => '是否菜单',
            'noClosable' => '是否可关闭',
            'breadcrumbHidden' => '是否隐藏面包屑',
            'hidden' => '是否隐藏详情',
            'dynamicNewTab' => '详情页是否可以打开多个',

            'weigh' => '权重',
            'extend' => '扩展信息',
            //            'role_ids' => '角色组'
            'guard' => '权限标识',
            'img' => '菜单封面',
            'type' => '类型',
        ];
    }
}
