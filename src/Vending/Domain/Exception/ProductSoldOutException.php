<?php

namespace App\Vending\Domain\Exception;

class ProductSoldOutException extends \Exception
{
    public function __construct(string $productName, ?\Throwable $previous = null)
    {
        $message = sprintf("Product '%s' is out of stock.", $productName);
        parent::__construct($message, 0, $previous);
    }
}
