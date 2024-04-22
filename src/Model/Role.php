<?php

namespace Ouhaohan8023\EasyRbac\Model;

use Kalnoy\Nestedset\NodeTrait;

class Role extends \Spatie\Permission\Models\Role
{
    use NodeTrait;

}
