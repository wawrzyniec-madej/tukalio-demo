<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingListItem;

use App\Command\ShoppingListItem\DeleteShoppingListItemCommandInterface;
use App\Exception\Entity\ShoppingListItemNotFoundException;
use Doctrine\ORM\NonUniqueResultException;

interface DeleteShoppingListItemCommandHandlerInterface
{
    /**
     * @throws ShoppingListItemNotFoundException
     * @throws NonUniqueResultException
     */
    public function handle(DeleteShoppingListItemCommandInterface $deleteShoppingListItemCommand): void;
}
