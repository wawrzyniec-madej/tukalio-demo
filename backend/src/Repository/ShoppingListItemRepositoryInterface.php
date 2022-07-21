<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ShoppingListItem;
use App\Exception\Entity\ShoppingListItemNotFoundException;
use Doctrine\ORM\NonUniqueResultException;

interface ShoppingListItemRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @throws ShoppingListItemNotFoundException
     * @throws NonUniqueResultException
     */
    public function getShoppingListItemByShoppingListHashAndShoppingListItemId(
        string $shoppingListHash,
        int $shoppingListItemId
    ): ShoppingListItem;
}
