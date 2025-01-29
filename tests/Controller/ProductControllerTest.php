<?php declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ProductControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->client->followRedirects();
    }

    public function testProductsEndpoint(): void
    {
        $this->client->request('GET', '/products/');
        self::assertResponseIsSuccessful(verbose: false);
    }

    public function testProductsWithEmptyCategory(): void
    {
        $this->client->request('GET', '/products?category=');
        self::assertJson($this->client->getResponse()->getContent());
        self::assertCount(5, json_decode($this->client->getResponse()->getContent(), true, flags: JSON_THROW_ON_ERROR));
    }

    public function testProductsWithEmptyPriceLessThan(): void
    {
        $this->client->request('GET', '/products?priceLessThan=');
        self::assertJson($this->client->getResponse()->getContent());
        self::assertCount(5, json_decode($this->client->getResponse()->getContent(), true, flags: JSON_THROW_ON_ERROR));
    }

    public function testProductsWithoutDiscount(): void
    {
        $this->client->request('GET', '/products?category=sandals');
        self::assertJsonStringEqualsJsonString(<<<JSON
            [
                {
                    "sku": "000004",
                    "name": "Naima embellished suede sandals",
                    "category": "sandals",
                    "price": {
                        "original": 79500,
                        "final": 79500,
                        "discount_percentage": null,
                        "currency": "EUR"
                    }
                }
            ]
            JSON, $this->client->getResponse()->getContent());
    }

    public function testProductsWithDiscount30(): void
    {
        $this->client->request('GET', '/products?category=boots');
        self::assertJsonStringEqualsJsonString(<<<JSON
            [
                {
                    "sku": "000001",
                    "name": "BV Lean leather ankle boots",
                    "category": "boots",
                    "price": {
                        "original": 89000,
                        "final": 62300,
                        "discount_percentage": "30%",
                        "currency": "EUR"
                    }
                },
                {
                    "sku": "000002",
                    "name": "BV Lean leather ankle boots",
                    "category": "boots",
                    "price": {
                        "original": 99000,
                        "final": 69300,
                        "discount_percentage": "30%",
                        "currency": "EUR"
                    }
                },
                {
                    "sku": "000003",
                    "name": "Ashlington leather ankle boots",
                    "category": "boots",
                    "price": {
                        "original": 71000,
                        "final": 49700,
                        "discount_percentage": "30%",
                        "currency": "EUR"
                    }
                }
            ]
            JSON, $this->client->getResponse()->getContent());
    }

    public function testProductsWithDiscount15(): void
    {
        $this->client->request('GET', '/products?category=b_stock');
        self::assertJsonStringEqualsJsonString(<<<JSON
            [
                {
                    "sku": "000003",
                    "name": "Ashlington leather ankle boots B-stock",
                    "category": "b_stock",
                    "price": {
                        "original": 71000,
                        "final": 60350,
                        "discount_percentage": "15%",
                        "currency": "EUR"
                    }
                }
            ]
            JSON, $this->client->getResponse()->getContent());
    }

    public function testProductsWithPriceLessThan(): void
    {
        $this->client->request('GET', '/products?priceLessThan=59000');
        self::assertJsonStringEqualsJsonString(<<<JSON
            [
                {
                    "sku": "000005",
                    "name": "Nathane leather sneakers",
                    "category": "sneakers",
                    "price": {
                        "original": 59000,
                        "final": 59000,
                        "discount_percentage": null,
                        "currency": "EUR"
                    }
                }
            ]
            JSON, $this->client->getResponse()->getContent());
    }

    public function testProductsWithCategoryAndPriceLessThan(): void
    {
        $this->client->request('GET', '/products?category=boots&priceLessThan=71000');
        self::assertJsonStringEqualsJsonString(<<<JSON
            [
                {
                    "sku": "000003",
                    "name": "Ashlington leather ankle boots",
                    "category": "boots",
                    "price": {
                        "original": 71000,
                        "final": 49700,
                        "discount_percentage": "30%",
                        "currency": "EUR"
                    }
                }
            ]
            JSON, $this->client->getResponse()->getContent());
    }
}
