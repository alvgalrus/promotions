<?php declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function testProductInstance(): void
    {
        $product = new Product(
            sku: '000001',
            name: 'BV Lean leather ankle boots',
            category: 'boots',
            price: 89000,
        );

        $this->assertEquals('000001', $product->getSku());
        $this->assertEquals('BV Lean leather ankle boots', $product->getName());
        $this->assertEquals('boots', $product->getCategory());
        $this->assertEquals(89000, $product->getPrice());
    }
}
