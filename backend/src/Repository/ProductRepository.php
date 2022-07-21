<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;

final class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findProductByName(string $name): ?Product
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->where(
                $qb->expr()->eq('p.name', ':productName')
            )
            ->setMaxResults(1)
            ->setParameter('productName', $name);

        $product = $qb->getQuery()->getOneOrNullResult();

        if (!$product instanceof Product) {
            return null;
        }

        return $product;
    }
}
