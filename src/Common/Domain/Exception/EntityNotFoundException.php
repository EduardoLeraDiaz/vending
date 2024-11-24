<?php

namespace App\Common\Domain\Exception;

use Exception;
use Throwable;

class EntityNotFoundException extends Exception
{
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
