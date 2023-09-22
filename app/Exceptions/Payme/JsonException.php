<?php

namespace App\Exceptions\Payme;

use App\Enum\Payme\ExceptionCode;
use App\Exceptions\PaymeException;
use Exception;

class JsonException extends PaymeException
{
    public static function jsonParsingError()
    {
        return static::new(
            ExceptionCode::JSON_PARSING_ERROR,
        );
    }
    public static function jsonRpcError()
    {
        return static::new(
            ExceptionCode::JSON_RPC_ERROR,
        );
    }
}
