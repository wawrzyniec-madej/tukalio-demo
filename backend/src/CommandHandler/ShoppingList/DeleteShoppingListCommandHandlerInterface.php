<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\DeleteShoppingListCommand;
use App\Exception\Entity\ShoppingListIsLockedException;
use App\Exception\Entity\ShoppingListNotFoundException;
use Doctrine\ORM\NonUniqueResultException;

interface DeleteShoppingListCommandHandlerInterface
{
    /**
     * @throws NonUniqueResultException
     * @throws ShoppingListNotFoundException
     * @throws ShoppingListIsLockedException
     */
    public function handle(DeleteShoppingListCommand $deleteShoppingListCommand): void;
}
