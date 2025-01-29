<?php declare(strict_types=1);

namespace App\Service;

use App\Adapter\FileReader;
use App\Entity\Product;
use JsonException;

readonly class JsonReader implements ProductReader
{
    public function __construct(
        private FileReader $fileReader,
        private string     $productsDataPath = '',
    ) {}

    /**
     * @return Product[]
     * @throws JsonException
     */
    public function load(): array
    {
        $data = json_decode(
            $this->fileReader->fileGetContents($this->productsDataPath),
            flags: JSON_THROW_ON_ERROR
        );

        $productList = [];
        foreach ($data->products as $productData) {
            $productList[] = new Product(
                $productData->sku,
                $productData->name,
                $productData->category,
                $productData->price,
            );
        }
        return $productList;
    }
}