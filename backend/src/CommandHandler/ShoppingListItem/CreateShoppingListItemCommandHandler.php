<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingListItem;

use App\Command\ShoppingListItem\CreateShoppingListItemCommandInterface;
use App\Container\AmplitudeEventContainerInterface;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Event\Amplitude\ShoppingListItemCreatedAmplitudeEvent;
use App\Factory\Dto\ShoppingListItemDtoFactoryInterface;
use App\Factory\Entity\ShoppingListItemFactoryInterface;
use App\Repository\ShoppingListItemRepositoryInterface;
use App\Repository\ShoppingListRepositoryInterface;
use App\Service\ProductServiceInterface;

final class CreateShoppingListItemCommandHandler implements CreateShoppingListItemCommandHandlerInterface
{
    public function __construct(
        private ShoppingListRepositoryInterface $shoppingListRepository,
        private ShoppingListItemFactoryInterface $shoppingListItemFactory,
        private ShoppingListItemRepositoryInterface $shoppingListItemRepository,
        private ShoppingListItemDtoFactoryInterface $shoppingListItemDtoFactory,
        private ProductServiceInterface $productService,
        private AmplitudeEventContainerInterface $amplitudeEventContainer
    ) {
    }

    public function handle(
        CreateShoppingListItemCommandInterface $createShoppingListItemCommand
    ): ShoppingListItemDtoInterface {
        $shoppingList = $this->shoppingListRepository->getShoppingListByHash(
            $createShoppingListItemCommand->getShoppingListHash()
        );

        $shoppingListItem = $this->shoppingListItemFactory->create(
            quantity: $createShoppingListItemCommand->getQuantity(),
            shoppingList: $shoppingList,
            name: $createShoppingListItemCommand->getName(),
            taken: false
        );

        $this->productService->addToUsedProducts(
            $createShoppingListItemCommand->getName()
        );

        $this->shoppingListItemRepository->save($shoppingListItem, true);

        $this->amplitudeEventContainer->addEvent(
            new ShoppingListItemCreatedAmplitudeEvent(
                $shoppingListItem->getId(),
                $shoppingListItem->getName(),
                $shoppingListItem->isTaken(),
                $shoppingListItem->getQuantity(),
                $shoppingList->getHash(),
                $shoppingList->getId()
            )
        );

        return $this->shoppingListItemDtoFactory->create(
            $shoppingListItem
        );
    }
}
