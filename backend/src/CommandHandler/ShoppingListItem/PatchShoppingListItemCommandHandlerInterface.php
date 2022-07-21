<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingListItem;

use App\Command\ShoppingListItem\PatchShoppingListItemCommandInterface;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Exception\Entity\ShoppingListItemNotFoundException;
use App\Exception\InvalidCollectionElementTypeException;
use Doctrine\ORM\NonUniqueResultException;

interface PatchShoppingListItemCommandHandlerInterface
{
    /**
     * @throws ShoppingListItemNotFoundException
     * @throws NonUniqueResultException
     * @throws InvalidCollectionElementTypeException
     */
    public function handle(PatchShoppingListItemCommandInterface $patchShoppingListItemCommand
    ): ShoppingListItemDtoInterface;
}
