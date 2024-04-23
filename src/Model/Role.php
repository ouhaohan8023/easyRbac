<?php

namespace Ouhaohan8023\EasyRbac\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;

class Role extends \Spatie\Permission\Models\Role
{
    use NodeTrait;

    protected $fillable = [
        'id',
        'team_foreign_key',
        'team_foreign_key',
        'name',
        'title',
        'show',
        'guard_name',
        'state',
        'parent_id',
    ];

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, RoleHasMenu::class, 'role_id', 'menu_id');
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            ModelHasRole::class,
            'role_id',
            'model_id'
        )->wherePivot('model_type', User::class);
    }
}
