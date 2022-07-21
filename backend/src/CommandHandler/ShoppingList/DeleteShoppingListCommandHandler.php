<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\DeleteShoppingListCommandInterface;
use App\Exception\Entity\ShoppingListIsLockedException;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Repository\ShoppingListRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;

final class DeleteShoppingListCommandHandler implements DeleteShoppingListCommandHandlerInterface
{
    public function __construct(
        private ShoppingListRepositoryInterface $shoppingListRepository
    ) {
    }

    public function handle(DeleteShoppingListCommandInterface $deleteShoppingListCommand): void
    {
        $shoppingList = $this->shoppingListRepository->getShoppingListByHash(
            $deleteShoppingListCommand->getShoppingListHash()
        );

        if (true === $shoppingList->isLocked()) {
            throw new ShoppingListIsLockedException();
        }

        $this->shoppingListRepository->remove($shoppingList);
        $this->shoppingListRepository->flush();
    }
}
