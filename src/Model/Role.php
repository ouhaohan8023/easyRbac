<?php

namespace Ouhaohan8023\EasyRbac\Model;

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
    ];
}
