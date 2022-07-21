<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingListItem;

use App\Command\ShoppingListItem\CreateShoppingListItemCommandInterface;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Exception\InvalidCollectionElementTypeException;
use Doctrine\ORM\NonUniqueResultException;

interface CreateShoppingListItemCommandHandlerInterface
{
    /**
     * @throws NonUniqueResultException
     * @throws ShoppingListNotFoundException
     * @throws InvalidCollectionElementTypeException
     */
    public function handle(CreateShoppingListItemCommandInterface $createShoppingListItemCommand
    ): ShoppingListItemDtoInterface;
}
