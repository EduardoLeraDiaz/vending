<?php

namespace App\Vending\Application\Query;

use App\Vending\Domain\Repository\AvailableCoinsRepositoryInterface;
use App\Vending\Domain\ValueObject\Coin;

readonly class CalculateCoinsForAmountQueryHandler
{
    public function __construct(
        private AvailableCoinsRepositoryInterface $availableCoinsRepository,
    ) {
    }
    public function handle(CalculateCoinsForAmountRequest $request): CalculateCoinsForAmountResponse
    {
        $purse = $this->availableCoinsRepository->getPurse();

        $remain = intval($request->amount * 100);
        $coins = [];

        foreach ($purse as $availableCoin) {
            $coinsNeeded = intdiv($remain, $availableCoin->getCentsValue());
            $coinsAmount = min($coinsNeeded, $availableCoin->getAmount());
            $coins = array_merge($coins, array_fill(0, $coinsAmount, new Coin($availableCoin->getCentsValue())));
            $remain = $remain - ($coinsAmount * $availableCoin->getCentsValue());
        }

        return new CalculateCoinsForAmountResponse($coins, $remain / 100);
    }
}
