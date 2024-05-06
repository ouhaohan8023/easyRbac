<?php

return [
    /**
     * 权限（路由）组
     * 假设路由为 system1.user.index
     * system1为key
     * 未列出的路由组不会被存储
     */
    'groups' => [
        'theater' => '剧场',
    ],

    /**
     * 是否启用中间件
     */
    'enable_middleware' => true,

    /**
     * 自定义超级管理员的名称
     * 超级管理员会跳过权限认证
     */
    'super_admin_key' => 'super_admin',

    /**
     * 菜单数据从数据库持久化到本地文件的位置
     * 默认是在 storage/app/menus.json
     */
    'menus' => 'menus.json',

    /**
     * 路由汉化
     * 在这个数组中的路由name会汉化
     */
    'permissions' => [
        'test.test.route' => '测试',
    ],

    /**
     * 用户模型
     * 当修改角色拥有的权限时，要同步修改用户的权限
     * 会遍历下面的模型，找到包含当前角色的用户模型，进行权限同步
     */
    'users' => [
        \App\Models\User::class,
    ],

    /**
     * 缓存Key名称
     */
    'cache' => [
        'permission' => 'easy-rbac-permissions',
    ],

    /**
     * 缓存Tag名称
     * 用于批量清除缓存
     */
    'cache_tag' => [
        'permission' => 'easy-rbac-permission-tag',
    ],
];
