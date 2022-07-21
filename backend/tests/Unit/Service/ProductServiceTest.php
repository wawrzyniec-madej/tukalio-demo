<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Product;
use App\Factory\Entity\ProductFactoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Service\ProductService;
use App\Service\ProductServiceInterface;
use PHPUnit\Framework\TestCase;

final class ProductServiceTest extends TestCase
{
    private ProductFactoryInterface $productFactory;
    private ProductRepositoryInterface $productRepository;
    private ProductServiceInterface $productService;

    public function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->productFactory = $this->createMock(ProductFactoryInterface::class);

        $this->productService = new ProductService(
            $this->productRepository,
            $this->productFactory
        );
    }

    public function test_addToUsedProducts_success(): void
    {
        $productName = 'product';

        $product = $this->createMock(Product::class);

        $this->productRepository
            ->expects($this->once())
            ->method('findProductByName')
            ->with($productName)
            ->willReturn($product);

        $product
            ->expects($this->once())
            ->method('incrementUsedTimes')
            ->willReturn($product);

        $this->productRepository
            ->expects($this->once())
            ->method('save')
            ->with($product);

        $this->productService->addToUsedProducts($productName);
    }
}
