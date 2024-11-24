<?php

namespace App\Vending\Infrastructure\Console;

use App\Vending\Domain\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;
readonly class ServiceCommandPayload
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Count(min: 1, minMessage: "It should be at least one product")]
        /** @var Product[] */
        public array $products
    )
    {
    }
}