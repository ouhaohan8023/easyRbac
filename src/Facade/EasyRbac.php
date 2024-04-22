<?php

namespace Ouhaohan8023\EasyRbac\Facade;
use Illuminate\Support\Facades\Facade;
class EasyRbac extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'easy-rbac';
    }
}
