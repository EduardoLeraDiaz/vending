<?php

namespace App\Vending\Domain\Entity;

use App\Vending\Infrastructure\Doctrine\DoctrineProductRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DoctrineProductRepository::class)]
#[ORM\Index(name: "product_selector_idx", columns: ['selector'])]
class Product implements JsonSerializable
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id,

        #[ORM\Column(length: 255)]
        #[Assert\length(max: 255)]
        private string $name,

        #[ORM\Column(length: 15)]
        #[Assert\length(max: 15)]
        private string $selector,

        #[ORM\Column]
        #[Assert\Range(min: 0.50)]
        private float $price,

        #[ORM\Column]
        #[Assert\PositiveOrZero]
        private int $stock,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSelector(): string
    {
        return $this->selector;
    }

    public function setSelector(string $selector): void
    {
        $this->selector = $selector;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'selector' => $this->selector,
            'stock' => $this->stock,
            'price' => $this->price,
        ];
    }
}
