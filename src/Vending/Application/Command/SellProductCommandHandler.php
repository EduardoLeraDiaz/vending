<?php

namespace App\Vending\Application\Command;

use App\Common\Domain\Exception\EntityNotFoundException;
use App\Vending\Domain\Exception\NotEnoughBalanceException;
use App\Vending\Domain\Exception\ProductSoldOutException;
use App\Vending\Domain\Repository\BalanceRepositoryInterface;
use App\Vending\Domain\Repository\ProductRepositoryInterface;

readonly class SellProductCommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private BalanceRepositoryInterface $balanceRepository,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     * @throws ProductSoldOutException
     * @throws NotEnoughBalanceException
     */
    public function handle(SellProductRequest $request): void
    {
        $product = $this->productRepository->getBySelector($request->selector);
        if ($this->balanceRepository->getBalance() < $product->getPrice()) {
            throw new NotEnoughBalanceException();
        }

        if ($product->getStock() === 0) {
            throw new ProductSoldOutException($product->getName());
        }

        $product->setStock($product->getStock() - 1);
        $this->productRepository->save($product);
        $this->balanceRepository->changeBalance(-$product->getPrice());
    }
}
