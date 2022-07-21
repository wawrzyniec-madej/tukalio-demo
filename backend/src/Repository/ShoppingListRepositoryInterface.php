<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ShoppingList;
use App\Exception\Entity\ShoppingListNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

interface ShoppingListRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @throws ShoppingListNotFoundException
     * @throws NonUniqueResultException
     */
    public function getShoppingListByHash(string $shoppingListHash): ShoppingList;

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function isShoppingListWithHash(string $shoppingListHash): bool;
}
