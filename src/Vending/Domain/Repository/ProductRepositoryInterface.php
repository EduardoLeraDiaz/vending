<?php

namespace App\Vending\Domain\Repository;

use App\Common\Domain\Exception\EntityNotFoundException;
use App\Vending\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function getAll(): array;
    public function save(Product $product): void;

    /**
     * @param array<Product> $products
     */
    public function bulkSave(array $products): void;

    /** @throws EntityNotFoundException */
    public function getBySelector(string $selector): Product;
}