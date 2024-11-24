<?php

namespace App\Vending\Domain\Entity;

use App\Vending\Infrastructure\Doctrine\DoctrineBalanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineBalanceRepository::class)]
class Balance
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id,

        #[ORM\Column]
        private float $amount
    ) {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }
}
