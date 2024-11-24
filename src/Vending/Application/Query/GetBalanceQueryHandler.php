<?php

namespace App\Vending\Application\Query;

use App\Vending\Domain\Repository\BalanceRepositoryInterface;

readonly class GetBalanceQueryHandler
{
    public function __construct(
      private BalanceRepositoryInterface $balanceRepository
    ) {

    }
    public function handle(GetBalanceRequest $request): GetBalanceResponse
    {
        $balance = $this->balanceRepository->getBalance();
        return new GetBalanceResponse($balance);
    }
}
