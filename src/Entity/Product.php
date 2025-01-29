<?php declare(strict_types=1);

namespace App\Entity;

readonly class Product
{
    public function __construct(
        private string $sku,
        private string $name,
        private string $category,
        private int    $price,
    ) {}

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}