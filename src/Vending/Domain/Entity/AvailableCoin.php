<?php

namespace App\Vending\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineProductRepository::class)]
#[ORM\Index(name: "coin_cent_idx", columns: ['cents_value'])]
class AvailableCoin
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        private int $centsValue,

        #[ORM\Column]
        private int $amount,
    ) {
    }

    public function getCentsValue(): int
    {
        return $this->centsValue;
    }

    public function setCentsValue(int $centsValue): void
    {
        $this->centsValue = $centsValue;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}
