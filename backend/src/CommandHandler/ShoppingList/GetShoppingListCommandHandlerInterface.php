<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\GetShoppingListCommandInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Exception\InvalidCollectionElementTypeException;
use Doctrine\ORM\NonUniqueResultException;

interface GetShoppingListCommandHandlerInterface
{
    /**
     * @throws ShoppingListNotFoundException
     * @throws InvalidCollectionElementTypeException
     * @throws NonUniqueResultException
     */
    public function handle(GetShoppingListCommandInterface $getShoppingListCommand): ShoppingListDtoInterface;
}
