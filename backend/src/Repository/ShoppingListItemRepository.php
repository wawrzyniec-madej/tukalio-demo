<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ShoppingListItem;
use App\Exception\Entity\ShoppingListItemNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

final class ShoppingListItemRepository extends AbstractRepository implements ShoppingListItemRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingListItem::class);
    }

    public function getShoppingListItemByShoppingListHashAndShoppingListItemId(
        string $shoppingListHash,
        int $shoppingListItemId
    ): ShoppingListItem {
        $qb = $this->createQueryBuilder('sli');

        $qb
            ->join('sli.shoppingList', 'sl')
            ->where(
                $qb->expr()->eq('sli.id', ':shoppingListItemId')
            )
            ->andWhere(
                $qb->expr()->eq('sl.hash', ':shoppingListHash')
            )
            ->setMaxResults(1)
            ->setParameters([
                'shoppingListItemId' => $shoppingListItemId,
                'shoppingListHash' => $shoppingListHash
            ]);

        $shoppingListItem = $qb->getQuery()->getOneOrNullResult();

        if (!$shoppingListItem instanceof ShoppingListItem) {
            throw new ShoppingListItemNotFoundException();
        }

        return $shoppingListItem;
    }
}
