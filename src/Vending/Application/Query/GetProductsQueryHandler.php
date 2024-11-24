<?php

namespace App\Vending\Application\Query;

use App\Vending\Domain\Repository\ProductRepositoryInterface;

readonly class GetProductsQueryHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    public function handle(GetProductsRequest $request): GetProductsResponse
    {
        $products = $this->productRepository->getAll();
        return new GetProductsResponse($products);
    }
}