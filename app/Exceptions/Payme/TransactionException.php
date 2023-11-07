<?php

namespace App\Exceptions\Payme;

use App\Enum\Payme\ExceptionCode;
use App\Exceptions\PaymeException;
use Exception;

class TransactionException extends PaymeException
{
    public static function cantCancelTransaction()
    {
        return static::new(
            ExceptionCode::CANT_CANCEL_TRANSACTION,
        );
    }

    public static function cantPerformTransaction()
    {
        return static::new(
            ExceptionCode::CANT_PERFORM_TRANSACTION,
        );
    }
    public static function timeoutExpired()
    {
        return static::new(
            ExceptionCode::CANT_PERFORM_TRANSACTION,
            [
                "uz" => "Bekor qilish muddati o'tgan",
                "ru" => "Тайм-аут прошел",
                "en" => "Timeout passed"
            ]
        );
    }
    public static function transactionNotFound()
    {
        return static::new(
            ExceptionCode::TRANSACTION_NOT_FOUND,
        );
    }
}
