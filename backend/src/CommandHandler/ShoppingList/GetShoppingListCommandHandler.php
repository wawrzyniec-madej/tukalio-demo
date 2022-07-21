<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\GetShoppingListCommandInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Exception\InvalidCollectionElementTypeException;
use App\Factory\Dto\ShoppingListDtoFactoryInterface;
use App\Repository\ShoppingListRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;

final class GetShoppingListCommandHandler implements GetShoppingListCommandHandlerInterface
{
    public function __construct(
        private ShoppingListRepositoryInterface $shoppingListRepository,
        private ShoppingListDtoFactoryInterface $shoppingListDtoFactory
    ) {
    }

    /**
     * @throws ShoppingListNotFoundException
     * @throws InvalidCollectionElementTypeException
     * @throws NonUniqueResultException
     */
    public function handle(GetShoppingListCommandInterface $getShoppingListCommand): ShoppingListDtoInterface
    {
        $shoppingList = $this->shoppingListRepository->getShoppingListByHash(
            $getShoppingListCommand->getShoppingListHash()
        );

        return $this->shoppingListDtoFactory->create($shoppingList);
    }
}
