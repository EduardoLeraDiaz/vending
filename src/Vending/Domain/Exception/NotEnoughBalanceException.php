<?php

namespace App\Vending\Domain\Exception;

class NotEnoughBalanceException extends \Exception
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('not enough balance',0, $previous);
    }
}
