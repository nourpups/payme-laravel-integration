<?php

namespace App\Enum\Order;

enum State: int
{
    case CART = 0;
    case PENDING = 1;
    case CONFIRMED = 2;
    case CANCELED = -1;

    /**
     * @return string
     */
    public function getName(): string
    {
        return match ($this) {
            self::CART => 'In cart',
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::CANCELED => 'Cancelled'
        };
    }
}
