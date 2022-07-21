<?php

declare(strict_types=1);

namespace App\Command\ShoppingListItem;

interface DeleteShoppingListItemCommandInterface
{
    public function getShoppingListHash(): string;

    public function getShoppingListItemId(): int;
}
