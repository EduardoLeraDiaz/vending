<?php

namespace App\Vending\Application\Command;

readonly class SellProductRequest
{
    public function __construct(
      public string $selector
    ) {
    }
}
