<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\Entity\ProductFactoryInterface;
use App\Repository\ProductRepositoryInterface;

final class ProductService implements ProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductFactoryInterface $productFactory
    ) {
    }

    public function addToUsedProducts(string $productName): void
    {
        $product = $this->productRepository->findProductByName($productName);

        if (null === $product) {
            $product = $this->productFactory->create(
                $productName
            );
        }

        $product->incrementUsedTimes();

        $this->productRepository->save($product);
    }
}
