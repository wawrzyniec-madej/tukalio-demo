<?php

declare(strict_types=1);

namespace App\Factory\Dto;

use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Entity\ShoppingListItem;

interface ShoppingListItemDtoFactoryInterface
{
    public function create(ShoppingListItem $shoppingListItem): ShoppingListItemDtoInterface;
}
