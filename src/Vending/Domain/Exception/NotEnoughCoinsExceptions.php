<?php

namespace App\Vending\Domain\Exception;

class NotEnoughCoinsExceptions extends \Exception
{
    public function __construct(int $cents, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Not enough %s coins', number_format($cents/100, 2)),0, $previous);
    }
}
