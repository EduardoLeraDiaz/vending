<?php

namespace App\Vending\Domain\ValueObject;

enum AcceptedCoins: int
{
    case FIVE_CENTS = 5;
    case TEN_CENTS = 10;
    case TWENTY_FIVE_CENTS = 25;
    case ONE = 100;
}
