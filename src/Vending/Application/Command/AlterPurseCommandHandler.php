<?php

namespace App\Vending\Application\Command;

use App\Vending\Domain\Entity\AvailableCoin;
use App\Vending\Domain\Repository\AvailableCoinsRepositoryInterface;

readonly class AlterPurseCommandHandler
{
    public function __construct(
      private AvailableCoinsRepositoryInterface $availableCoinsRepository,
    ) {
    }

    public function handle(AlterPurseRequest $request): void
    {
        foreach ($request->coinsAmount as $coinAmount) {
            $this->availableCoinsRepository->changeAmount($coinAmount->getCentsValue(), $coinAmount->getAmount());
        }
    }
}
