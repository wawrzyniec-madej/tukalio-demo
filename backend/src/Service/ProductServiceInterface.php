<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\NonUniqueResultException;

interface ProductServiceInterface
{
    /**
     * @throws NonUniqueResultException
     */
    public function addToUsedProducts(string $productName): void;
}
