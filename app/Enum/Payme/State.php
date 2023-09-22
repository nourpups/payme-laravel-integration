<?php

namespace App\Enum\Payme;

enum State: int
{
    case PENDING = 1;
    case DONE = 2;
    case CANCELLED = -1;
    case CANCELLED_AFTER_DONE = -2;
}
