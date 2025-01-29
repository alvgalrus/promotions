<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;

class Calculator
{
    public static function discount(Product $product): int
    {
        $discounts = [];

        if ($product->getCategory() === 'boots') {
            $discounts[] = 30;
        }

        if ($product->getSku() === '000003') {
            $discounts[] = 15;
        }

        return empty($discounts) ? 0 : max($discounts);
    }
}