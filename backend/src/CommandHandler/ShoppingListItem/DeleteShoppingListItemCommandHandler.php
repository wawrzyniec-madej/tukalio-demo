<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingListItem;

use App\Command\ShoppingListItem\DeleteShoppingListItemCommandInterface;
use App\Exception\Entity\ShoppingListItemNotFoundException;
use App\Repository\ShoppingListItemRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;

final class DeleteShoppingListItemCommandHandler implements DeleteShoppingListItemCommandHandlerInterface
{
    public function __construct(
        private ShoppingListItemRepositoryInterface $shoppingListItemRepository
    ) {
    }

    /**
     * @throws ShoppingListItemNotFoundException
     * @throws NonUniqueResultException
     */
    public function handle(DeleteShoppingListItemCommandInterface $deleteShoppingListItemCommand): void
    {
        $shoppingListItem = $this->shoppingListItemRepository->getShoppingListItemByShoppingListHashAndShoppingListItemId(
            $deleteShoppingListItemCommand->getShoppingListHash(),
            $deleteShoppingListItemCommand->getShoppingListItemId()
        );

        $this->shoppingListItemRepository->remove($shoppingListItem);
        $this->shoppingListItemRepository->flush();
    }
}
