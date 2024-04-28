<?php

namespace Ouhaohan8023\EasyRbac\Exception;

use Throwable;

class HasRoleException extends \Exception
{
    public function __construct(
        $message = "需要检查是否有 HasRoles Trait",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
