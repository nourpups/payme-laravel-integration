<?php

namespace App\Exceptions;

use App\Enum\Payme\ExceptionCode;
use Exception;

class PaymeException extends Exception
{
    protected array $error;

    public static function new(
        ExceptionCode $code,
                      $customMessage = null,
                      $data = null
    ) {
       $exception = new static();

       $exception->error = [
         'code' => $code->value,
         'message' => $customMessage ?? $code->getMessage($code)
       ];

       return $exception;
    }
    public function getError(): array {
        return $this->error;
    }
}
