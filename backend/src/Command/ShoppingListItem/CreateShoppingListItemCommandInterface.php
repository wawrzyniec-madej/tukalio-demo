<?php

declare(strict_types=1);

namespace App\Command\ShoppingListItem;

interface CreateShoppingListItemCommandInterface
{
    public function getShoppingListHash(): string;

    public function getQuantity(): int;

    public function getName(): string;
}
