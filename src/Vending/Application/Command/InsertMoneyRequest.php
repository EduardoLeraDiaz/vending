<?php

namespace App\Vending\Application\Command;

use App\Vending\Domain\ValueObject\Coin;

readonly class InsertMoneyRequest
{
    public function __construct(
        public Coin $coin,
    ) {
    }
}
