<?php

namespace App\Exceptions\Payme;

use App\Enum\Payme\ExceptionCode;
use App\Exceptions\PaymeException;
use Exception;

class HttpException extends PaymeException
{
    public static function invalidHttpMethod()
    {
        return static::new(
            ExceptionCode::INVALID_HTTP_METHOD,
        );
    }
    public static function methodNotFound()
    {
        return static::new(
            ExceptionCode::METHOD_NOT_FOUND,
        );
    }
}
