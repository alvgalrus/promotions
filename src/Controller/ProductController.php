<?php declare(strict_types=1);

namespace App\Controller;

use App\DTO\PriceDto;
use App\DTO\ProductDto;
use App\Entity\Currency;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private const int PRODUCTS_LIMIT_RESULTS = 5;

    #[Route('/products', name: 'products', methods: ['GET'])]
    public function getProducts(
        Request $request,
        ProductRepository $productRepository,
        Calculator $calculator,
    ): JsonResponse
    {
        $categoryFilter = $request->query->get('category') ?: null;
        $priceLessThanFilter = $request->query->get('priceLessThan');

        if (($priceLessThanFilter !== '' && $priceLessThanFilter !== null) && (!ctype_digit($priceLessThanFilter) || (int)$priceLessThanFilter < 0)) {
            return new JsonResponse(['error' => 'Invalid priceLessThan parameter.'], Response::HTTP_BAD_REQUEST);
        }
        $priceLessThanFilter = !empty($priceLessThanFilter) ? (int)$priceLessThanFilter : null;

        # Filter and limit
        $filteredProducts = $productRepository->findByFilters($categoryFilter, $priceLessThanFilter, self::PRODUCTS_LIMIT_RESULTS);

        $responseProducts = [];
        foreach ($filteredProducts as $product) {
            $discountPercentage = $calculator->discount($product);
            $responseProducts[] = $this->formatProduct($product, $discountPercentage);
        }

        return new JsonResponse($responseProducts);
    }

    private function formatProduct(Product $product, int $discountPercentage): ProductDto
    {
        $originalPrice = $product->getPrice();

        return new ProductDto(
            sku: $product->getSku(),
            name: $product->getName(),
            category: $product->getCategory(),
            price: new PriceDto(
                original: $originalPrice,
                final: $originalPrice - (int)round($originalPrice * $discountPercentage / 100),
                discount_percentage: $discountPercentage ? "{$discountPercentage}%" : null,
                currency: Currency::EUR,
            ),
        );
    }
}