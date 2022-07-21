<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\Entity\Product;

final class ProductFactory implements ProductFactoryInterface
{
    public function create(string $name): Product
    {
        return new Product(
            $name
        );
    }
}
