<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\PatchShoppingListCommandInterface;
use App\Container\AmplitudeEventContainerInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Entity\ShoppingList;
use App\Event\Amplitude\ShoppingListNameUpdatedAmplitudeEvent;
use App\Event\Amplitude\ShoppingListUpdateStartedAmplitudeEvent;
use App\Exception\InvalidCollectionElementTypeException;
use App\Factory\Dto\ShoppingListDtoFactoryInterface;
use App\Repository\ShoppingListRepositoryInterface;

final class PatchShoppingListCommandHandler implements PatchShoppingListCommandHandlerInterface
{
    public function __construct(
        private ShoppingListRepositoryInterface $shoppingListRepository,
        private ShoppingListDtoFactoryInterface $shoppingListDtoFactory,
        private AmplitudeEventContainerInterface $amplitudeEventContainer
    ) {
    }

    public function handle(PatchShoppingListCommandInterface $patchShoppingListCommand): ShoppingListDtoInterface
    {
        $shoppingList = $this->shoppingListRepository->getShoppingListByHash(
            $patchShoppingListCommand->getShoppingListHash()
        );

        $this->amplitudeEventContainer->addEvent(
            new ShoppingListUpdateStartedAmplitudeEvent(
                $shoppingList->getHash(),
                $shoppingList->getId()
            )
        );

        $this->updateShoppingListName(
            $shoppingList,
            $patchShoppingListCommand
        );

        $this->shoppingListRepository->save($shoppingList, true);

        return $this->shoppingListDtoFactory->create($shoppingList);
    }

    /**
     * @throws InvalidCollectionElementTypeException
     */
    private function updateShoppingListName(
        ShoppingList $shoppingList,
        PatchShoppingListCommandInterface $patchShoppingListCommand
    ): void {
        if (null === $patchShoppingListCommand->getName()) {
            return;
        }

        $shoppingList->updateName(
            $patchShoppingListCommand->getName()
        );

        $this->amplitudeEventContainer->addEvent(
            new ShoppingListNameUpdatedAmplitudeEvent(
                $shoppingList->getName(),
                $shoppingList->getHash(),
                $shoppingList->getId()
            )
        );
    }
}
