<?php

namespace App\Exceptions\Payme;

use App\Enum\Payme\ExceptionCode;
use App\Exceptions\PaymeException;

class AuthException extends PaymeException
{
    public static function authError()
    {
        return static::new(
            ExceptionCode::AUTH_ERROR,
        );
    }
}
