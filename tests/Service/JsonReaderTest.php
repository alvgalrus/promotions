<?php declare(strict_types=1);

namespace App\Tests\Service;

use App\Adapter\FileReader;
use App\Service\JsonReader;
use JsonException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

final class JsonReaderTest extends TestCase
{
    /**
     * @throws Exception|JsonException
     */
    public function testJsonLoad(): void
    {
        $fileReaderMock = $this->createMock(FileReader::class);
        $fileReaderMock->method('fileGetContents')->willReturn(<<<JSON
            {
                "products": [
                    {
                        "sku": "000001",
                        "name": "BV Lean leather ankle boots",
                        "category": "boots",
                        "price": 89000
                    },
                    {
                        "sku": "000002",
                        "name": "BV Lean leather ankle boots",
                        "category": "boots",
                        "price": 99000
                    }
               ]
            }
        JSON);

        $productList = (new JsonReader($fileReaderMock))->load();
        $this->assertEquals('000001', $productList[0]->getSku());
        $this->assertEquals('BV Lean leather ankle boots', $productList[0]->getName());
        $this->assertEquals('boots', $productList[0]->getCategory());
        $this->assertEquals(89000, $productList[0]->getPrice());
        $this->assertEquals(99000, $productList[1]->getPrice());
    }
}
