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
];
