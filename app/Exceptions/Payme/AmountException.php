<?php

namespace App\Exceptions\Payme;

use App\Enum\Payme\ExceptionCode;
use App\Exceptions\PaymeException;
use Exception;

class AmountException extends PaymeException
{
    public static function wrongAmount()
    {
        return static::new(
            ExceptionCode::WRONG_AMOUNT,
        );
    }
}
