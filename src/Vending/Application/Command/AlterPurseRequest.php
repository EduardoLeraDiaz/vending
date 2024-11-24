<?php

namespace App\Vending\Application\Command;

use App\Vending\Domain\Entity\AvailableCoin;
use App\Vending\Domain\ValueObject\Coin;

readonly class AlterPurseRequest
{
    public function __construct(
      /** @var AvailableCoin[] $coinsAmount */
      public array $coinsAmount,
    ) {
    }

    /** @var Coin[] $coins */
    public static function fromCoins(array $coins): self
    {
        /** @var AvailableCoin[] $availableCoins */
        $availableCoins = [];
        foreach ($coins as $coin) {
            if (!array_key_exists($coin->getCents(), $availableCoins)) {
                $availableCoins[$coin->getCents()] = new AvailableCoin($coin->getCents(), 1);
                continue;
            }
            $amount = $availableCoins[$coin->getCents()]->getAmount();
            $availableCoins[$coin->getCents()]->setAmount($amount+1);
        }

        return new self($availableCoins);
    }
}
