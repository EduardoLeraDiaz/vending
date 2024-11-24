<?php

namespace App\Vending\Application\Query;

readonly class CalculateCoinsForAmountRequest
{
    public function __construct(
        public float $amount,
    ) {
    }
}
