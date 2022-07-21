<?php

declare(strict_types=1);

namespace App\Factory\Dto;

use App\Dto\ShoppingListItem\ShoppingListItemDto;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Entity\ShoppingListItem;

final class ShoppingListItemDtoFactory implements ShoppingListItemDtoFactoryInterface
{
    public function create(ShoppingListItem $shoppingListItem): ShoppingListItemDtoInterface
    {
        return new ShoppingListItemDto($shoppingListItem);
    }
}
