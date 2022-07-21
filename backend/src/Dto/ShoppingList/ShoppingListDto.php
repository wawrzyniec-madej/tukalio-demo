<?php

declare(strict_types=1);

namespace App\Dto\ShoppingList;

use App\Collection\Dto\ShoppingListItemDtoCollection;
use App\Entity\ShoppingList;

final class ShoppingListDto implements ShoppingListDtoInterface
{
    private string $hash;
    private string $name;
    private ShoppingListItemDtoCollection $shoppingListItemDtoCollection;

    public function __construct(
        ShoppingList $shoppingList,
        ShoppingListItemDtoCollection $shoppingListItemDtoCollection
    ) {
        $this->hash = $shoppingList->getHash();
        $this->name = $shoppingList->getName();
        $this->shoppingListItemDtoCollection = $shoppingListItemDtoCollection;
    }

    public function jsonSerialize(): array
    {
        return [
            'hash' => $this->hash,
            'name' => $this->name,
            'shoppingListItems' => $this->shoppingListItemDtoCollection
        ];
    }
}
