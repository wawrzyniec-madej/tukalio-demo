<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory\Entity;

use App\Entity\Product;
use App\Factory\Entity\ProductFactory;
use App\Factory\Entity\ProductFactoryInterface;
use PHPUnit\Framework\TestCase;

final class ProductFactoryTest extends TestCase
{
    private ProductFactoryInterface $productFactory;

    public function setUp(): void
    {
        $this->productFactory = new ProductFactory();
    }

    public function test_create_success(): void
    {
        $product = new Product('product');

        $result = $this->productFactory->create('product');

        self::assertEquals(
            $product,
            $result
        );
    }
}
