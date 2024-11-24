<?php

namespace App\Vending\Domain\Repository;

use App\Vending\Domain\Entity\AvailableCoin;

interface AvailableCoinsRepositoryInterface
{
    /** @return AvailableCoin[] */
    public function getPurse(): array;
    public function getAmountByCentValue(int $cents): int;
    public function changeAmount(int $cents, int $variation): void;
}
