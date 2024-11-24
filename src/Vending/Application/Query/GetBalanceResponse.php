<?php

namespace App\Vending\Application\Query;

readonly class GetBalanceResponse
{
    function __construct(public float $balance)
    {

    }
}