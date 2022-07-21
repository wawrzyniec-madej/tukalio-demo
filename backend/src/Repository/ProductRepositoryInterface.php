<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\NonUniqueResultException;

interface ProductRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @throws NonUniqueResultException
     */
    public function findProductByName(string $name): ?Product;
}
