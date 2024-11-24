<?php

namespace App\Vending\Domain\ValueObject;
use Exception;

readonly class Coin
{
    /**
     * @throws Exception
     */
    public function __construct(public int $cents)
    {
        if (!self::isCorrectValue($cents)) {
            throw new Exception('invalid coin');
        }
    }

    public function getCents(): int {
        return $this->cents;
    }
    public function getValue(): float
    {
        return $this->cents / 100;
    }

    static public function isCorrectValue(int $cents): bool
    {
        return in_array($cents, array_column(AcceptedCoins::cases(), 'value'));
    }
}
