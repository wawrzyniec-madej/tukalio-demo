<?php

declare(strict_types=1);

namespace App\Tests\Database;

use App\DataFixtures\Product\ProductFixtures;
use App\Repository\ProductRepositoryInterface;
use Exception;

final class ProductRepositoryTest extends AbstractDatabaseTestCase
{
    private ProductRepositoryInterface $productRepository;

    public function setUp(): void
    {
        $this->productRepository = self::getContainer()->get(ProductRepositoryInterface::class);

        $this->databaseTool->loadFixtures([
            ProductFixtures::class
        ]);
    }

    /** @throws Exception */
    public function test_findProductByName_success(): void
    {
        $product = $this->productRepository->findProductByName('orzechy');

        self::assertNotNull($product);
    }

    /** @throws Exception */
    public function test_findProductByName_null(): void
    {
        $product = $this->productRepository->findProductByName('notExistingProduct');

        self::assertNull($product);
    }
}
