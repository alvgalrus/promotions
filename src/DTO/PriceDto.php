<?php declare(strict_types=1);

namespace App\DTO;

use App\Entity\Currency;

final readonly class PriceDto
{
    public function __construct(
        public int      $original,
        public int      $final,
        public ?string  $discount_percentage,
        public Currency $currency,
    ) {}
}