<?php

declare(strict_types=1);

namespace App\Factory\Dto;

use App\Collection\Dto\ShoppingListItemDtoCollection;
use App\Dto\ShoppingList\ShoppingListDto;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;
use App\Exception\InvalidCollectionElementTypeException;

final class ShoppingListDtoFactory implements ShoppingListDtoFactoryInterface
{
    public function __construct(
        private ShoppingListItemDtoFactoryInterface $shoppingListItemDtoFactory
    ) {
    }

    /**
     * @throws InvalidCollectionElementTypeException
     */
    public function create(ShoppingList $shoppingList): ShoppingListDtoInterface
    {
        $shoppingListItems = $shoppingList->getShoppingListItems();

        $shoppingListItemDtoCollection = new ShoppingListItemDtoCollection();

        /** @var ShoppingListItem $shoppingListItem */
        foreach ($shoppingListItems as $shoppingListItem) {
            $shoppingListItemDtoCollection->add(
                $this->shoppingListItemDtoFactory->create($shoppingListItem)
            );
        }

        return new ShoppingListDto(
            $shoppingList,
            $shoppingListItemDtoCollection
        );
    }
}
