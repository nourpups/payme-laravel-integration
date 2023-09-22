<?php

namespace App\Exceptions\Payme;

use App\Enum\Payme\ExceptionCode;
use App\Exceptions\PaymeException;
use Exception;

class OrderException extends PaymeException
{
    public static function orderNotFound()
    {
        return static::new(
            ExceptionCode::ORDER_NOT_FOUND,
        );
    }
}
