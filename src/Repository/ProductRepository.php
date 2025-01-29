<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Service\ProductReader;
use JsonException;

class ProductRepository
{
    private const int DEFAULT_QUERY_LIMIT = 10;

    /**
     * @var Product[]
     */
    private array $products;

    /**
     * @throws JsonException
     */
    public function __construct(
        ProductReader $productReader,
    )
    {
        $this->products = $productReader->load();
    }

    /**
     * @return Product[]
     */
    public function findAll(): array
    {
        return $this->products;
    }

    /**
     * @return Product[]
     */
    public function findByFilters(
        ?string $category = null,
        ?int $priceLessThan = null,
        int $limit = self::DEFAULT_QUERY_LIMIT,
    ): array
    {
        $filteredProducts = [];
        foreach ($this->findAll() as $product) {
            if ($category !== null && $product->getCategory() !== $category) {
                continue;
            }
            if ($priceLessThan !== null && $product->getPrice() > $priceLessThan) {
                continue;
            }
            $filteredProducts[] = $product;
        }

        return array_slice($filteredProducts, 0, $limit);
    }
}