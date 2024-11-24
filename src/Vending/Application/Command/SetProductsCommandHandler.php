<?php

namespace App\Vending\Application\Command;

use App\Vending\Domain\Repository\ProductRepositoryInterface;

readonly class SetProductsCommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    public function handle(SetProductsRequest $request): void
    {
        $this->productRepository->bulkSave($request->products);
    }
}
