<?php declare(strict_types=1);

namespace App\DTO;

final readonly class ProductDto
{
    public function __construct(
        public string   $sku,
        public string   $name,
        public string   $category,
        public PriceDto $price,
    ) {}
}