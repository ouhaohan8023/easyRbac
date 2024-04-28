<?php
/*
 * Copyright (c) 2024. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace Ouhaohan8023\EasyRbac\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;

class Menu extends Model
{
    use NodeTrait;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'parent_id',
        'name',
        'path',
        'component',
        'redirect',
        'hidden',
        'levelHidden',
        'title',
        'icon',
        'isCustomSvg',
        'noKeepAlive',
        'noClosable',
        'noColumn',
        'badge',
        'tabHidden',
        'activeMenu',
        'dot',
        'dynamicNewTab',
        'breadcrumbHidden',
        'system',
        'weigh',
        'img',
        'type',
        'fullscreen'
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, RoleHasMenu::class, 'menu_id', 'role_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, MenuHasPermission::class, 'menu_id', 'permission_id');
    }
}
