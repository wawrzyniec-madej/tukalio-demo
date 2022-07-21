<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingListItem;

use App\Command\ShoppingListItem\PatchShoppingListItemCommandInterface;
use App\Container\AmplitudeEventContainerInterface;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Entity\ShoppingListItem;
use App\Event\Amplitude\ShoppingListItemNameUpdatedAmplitudeEvent;
use App\Event\Amplitude\ShoppingListItemTakenUpdatedAmplitudeEvent;
use App\Exception\InvalidCollectionElementTypeException;
use App\Factory\Dto\ShoppingListItemDtoFactoryInterface;
use App\Repository\ShoppingListItemRepositoryInterface;
use App\Service\ProductServiceInterface;

final class PatchShoppingListItemCommandHandler implements PatchShoppingListItemCommandHandlerInterface
{
    public function __construct(
        private ShoppingListItemRepositoryInterface $shoppingListItemRepository,
        private ShoppingListItemDtoFactoryInterface $shoppingListItemDtoFactory,
        private ProductServiceInterface $productService,
        private AmplitudeEventContainerInterface $amplitudeEventContainer
    ) {
    }

    public function handle(PatchShoppingListItemCommandInterface $patchShoppingListItemCommand
    ): ShoppingListItemDtoInterface {
        $shoppingListItem = $this->shoppingListItemRepository->getShoppingListItemByShoppingListHashAndShoppingListItemId(
            $patchShoppingListItemCommand->getShoppingListHash(),
            $patchShoppingListItemCommand->getShoppingListItemId()
        );

        $shoppingList = $shoppingListItem->getShoppingList();

        $this->updateShoppingListItemName(
            $shoppingListItem,
            $patchShoppingListItemCommand,
            $shoppingList->getHash()
        );

        $this->updateShoppingListItemQuantity(
            $shoppingListItem,
            $patchShoppingListItemCommand
        );

        $this->updateShoppingListItemTaken(
            $shoppingListItem,
            $patchShoppingListItemCommand,
            $shoppingList->getHash()
        );

        $this->updateShoppingListItemPositionY(
            $shoppingListItem,
            $patchShoppingListItemCommand
        );

        $this->shoppingListItemRepository->save($shoppingListItem, true);

        return $this->shoppingListItemDtoFactory->create($shoppingListItem);
    }

    private function updateShoppingListItemPositionY(
        ShoppingListItem $shoppingListItem,
        PatchShoppingListItemCommandInterface $patchShoppingListItemCommand
    ): void {
        if (null === $patchShoppingListItemCommand->getPositionY()) {
            return;
        }

        $shoppingListItem->setPositionY(
            $patchShoppingListItemCommand->getPositionY()
        );
    }

    private function updateShoppingListItemTaken(
        ShoppingListItem $shoppingListItem,
        PatchShoppingListItemCommandInterface $patchShoppingListItemCommand,
        string $shoppingListHash
    ): void {
        if (null === $patchShoppingListItemCommand->getTaken()) {
            return;
        }

        $shoppingListItem->updateTaken(
            $patchShoppingListItemCommand->getTaken()
        );

        $this->amplitudeEventContainer->addEvent(
            new ShoppingListItemTakenUpdatedAmplitudeEvent(
                $shoppingListItem->isTaken(),
                $shoppingListHash,
                $shoppingListItem->getId()
            )
        );
    }

    /**
     * @throws InvalidCollectionElementTypeException
     */
    private function updateShoppingListItemName(
        ShoppingListItem $shoppingListItem,
        PatchShoppingListItemCommandInterface $patchShoppingListItemCommand,
        string $shoppingListHash
    ): void {
        if (null === $patchShoppingListItemCommand->getName()) {
            return;
        }

        $shoppingListItem->updateName(
            $patchShoppingListItemCommand->getName()
        );

        $this->productService->addToUsedProducts(
            $patchShoppingListItemCommand->getName()
        );

        $this->amplitudeEventContainer->addEvent(
            new ShoppingListItemNameUpdatedAmplitudeEvent(
                $shoppingListItem->getName(),
                $shoppingListHash,
                $shoppingListItem->getId()
            )
        );
    }

    private function updateShoppingListItemQuantity(
        ShoppingListItem $shoppingListItem,
        PatchShoppingListItemCommandInterface $patchShoppingListItemCommand
    ): void {
        if (null === $patchShoppingListItemCommand->getQuantity()) {
            return;
        }

        $shoppingListItem->updateQuantity(
            $patchShoppingListItemCommand->getQuantity()
        );
    }
}
