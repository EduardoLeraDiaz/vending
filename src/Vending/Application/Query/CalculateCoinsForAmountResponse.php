<?php

namespace App\Vending\Application\Query;

use App\Vending\Domain\ValueObject\Coin;

readonly class CalculateCoinsForAmountResponse
{
    public function __construct(
        /** @var Coin[] $coins */
        public array $coins,
        public float $remain=0,
    ) {
        if ($this->remain < 0) {
            throw new \Exception('parameter remain can\'t be negative');
        }
    }
}
