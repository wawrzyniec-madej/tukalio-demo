<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\Entity\Product;

interface ProductFactoryInterface
{
    public function create(string $name): Product;
}
