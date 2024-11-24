<?php

namespace App\Vending\Application\Query;

use App\Vending\Domain\Entity\Product;

readonly class GetProductsResponse
{
    public function __construct(
      /** @var Product[] */
      public array $products
    ) {
    }
}
