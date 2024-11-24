<?php

namespace App\Vending\Application\Command;

use App\Vending\Domain\Repository\AvailableCoinsRepositoryInterface;
use App\Vending\Domain\Repository\BalanceRepositoryInterface;

readonly class InsertMoneyCommandHandler
{
    public function __construct(
        private BalanceRepositoryInterface $balanceRepository,
        private AvailableCoinsRepositoryInterface $availableCoinsRepository,
    ) {

    }
    public function handle(InsertMoneyRequest $request): void
    {
        $this->balanceRepository->changeBalance($request->coin->getValue());
        $this->availableCoinsRepository->changeAmount($request->coin->getCents(), 1);
    }
}
