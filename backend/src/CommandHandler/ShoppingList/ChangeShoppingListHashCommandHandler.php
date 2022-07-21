<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\ChangeShoppingListHashCommandInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Factory\Dto\ShoppingListDtoFactoryInterface;
use App\Repository\ShoppingListRepositoryInterface;
use App\Service\HashGeneratorServiceInterface;

final class ChangeShoppingListHashCommandHandler implements ChangeShoppingListHashCommandHandlerInterface
{
    public function __construct(
        private ShoppingListRepositoryInterface $shoppingListRepository,
        private ShoppingListDtoFactoryInterface $shoppingListDtoFactory,
        private HashGeneratorServiceInterface $hashGeneratorService
    ) {
    }

    public function handle(ChangeShoppingListHashCommandInterface $changeShoppingListHashCommand
    ): ShoppingListDtoInterface {
        $shoppingList = $this->shoppingListRepository->getShoppingListByHash(
            $changeShoppingListHashCommand->getShoppingListHash()
        );

        $shoppingList->updateHash(
            $this->hashGeneratorService->generateHash()
        );

        $this->shoppingListRepository->save($shoppingList, true);

        return $this->shoppingListDtoFactory->create($shoppingList);
    }
}
