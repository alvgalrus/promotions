<?php declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Product;
use App\Service\Calculator;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    /**
     * @throws Exception
     */
    #[DataProvider('categorySkuProvider')]
    public function testCalculateDiscount(string $category, string $sku, int $expectedDiscount): void
    {
        $productMock = $this->createMock(Product::class);
        $productMock->method('getCategory')->willReturn($category);
        $productMock->method('getSku')->willReturn($sku);

        $discount = Calculator::discount($productMock);
        self::assertEquals($expectedDiscount, $discount);
    }

    public static function categorySkuProvider(): Generator
    {
        yield ['sandals', '000001', 0];
        yield ['boots', '000001', 30];
        yield ['sandals', '000003', 15];
        yield ['boots', '000003', 30];
    }
}
