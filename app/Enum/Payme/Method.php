<?php

namespace App\Enum\Payme;

enum Method: string
{
    case CheckPerformTransaction = 'CheckPerformTransaction';
    case CreateTransaction = 'CreateTransaction';
    case PerformTransaction = 'PerformTransaction';
    case CancelTransaction = 'CancelTransaction';
    case CheckTransaction = 'CheckTransaction';
    case GetStatement = 'GetStatement';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->name;
        }
        return $array;
    }

}
