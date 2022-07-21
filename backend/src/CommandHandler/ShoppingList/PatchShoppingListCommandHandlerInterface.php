<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\PatchShoppingListCommandInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Exception\InvalidCollectionElementTypeException;
use Doctrine\ORM\NonUniqueResultException;

interface PatchShoppingListCommandHandlerInterface
{
    /**
     * @throws NonUniqueResultException
     * @throws ShoppingListNotFoundException
     * @throws InvalidCollectionElementTypeException
     */
    public function handle(PatchShoppingListCommandInterface $patchShoppingListCommand): ShoppingListDtoInterface;
}
