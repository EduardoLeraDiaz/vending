<?php

namespace App\Vending\Domain\Repository;
interface BalanceRepositoryInterface
{
    public function getBalance():float;
    public function changeBalance(float $amount): void;
    public function resetBalance(): void;
}