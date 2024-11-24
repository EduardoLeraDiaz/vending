<?php

namespace App\Vending\Application\Command;

use App\Vending\Domain\Repository\BalanceRepositoryInterface;

readonly class ResetBalanceCommandHandler
{
    public function __construct(
        private BalanceRepositoryInterface $balanceRepository
    ) {
    }
    public function handle(ResetBalanceRequest $request): void
    {
        $this->balanceRepository->resetBalance();
    }
}
