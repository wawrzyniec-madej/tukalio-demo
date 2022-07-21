<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ShoppingList;
use App\Exception\Entity\ShoppingListNotFoundException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

final class ShoppingListRepository extends AbstractRepository implements ShoppingListRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingList::class);
    }

    private function addOrderByShoppingListItemPositionY(QueryBuilder $queryBuilder): void
    {
        $queryBuilder
            ->addOrderBy(
                'sli.positionY', 'asc'
            );
    }

    public function getShoppingListByHash(string $shoppingListHash): ShoppingList
    {
        $qb = $this->createQueryBuilder('sl');

        $qb
            ->select([
                'sl',
                'sli'
            ])
            ->leftJoin('sl.shoppingListItems', 'sli')
            ->where(
                $qb->expr()->eq('sl.hash', ':shoppingListHash')
            )
            ->setParameter('shoppingListHash', $shoppingListHash);

        $this->addOrderByShoppingListItemPositionY($qb);

        $shoppingList = $qb->getQuery()->getOneOrNullResult();

        if (!$shoppingList instanceof ShoppingList) {
            throw new ShoppingListNotFoundException();
        }

        return $shoppingList;
    }

    public function isShoppingListWithHash(string $shoppingListHash): bool
    {
        $qb = $this->createQueryBuilder('sl');

        $qb
            ->select('1')
            ->where(
                $qb->expr()->eq('sl.hash', ':shoppingListHash')
            )
            ->setParameter('shoppingListHash', $shoppingListHash);

        $shoppingListCount = $qb->getQuery()->getOneOrNullResult();

        return $shoppingListCount !== null;
    }
}
