<?php

namespace App\Vending\Application\Command;

readonly class SetProductsRequest
{
    /**
     * @param array $products
     */
    public function __construct(
        public array $products
    ) {
    }
}
