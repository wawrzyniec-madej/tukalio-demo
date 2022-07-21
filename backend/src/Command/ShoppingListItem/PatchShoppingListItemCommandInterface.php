<?php

declare(strict_types=1);

namespace App\Command\ShoppingListItem;

interface PatchShoppingListItemCommandInterface
{
    public function getShoppingListItemId(): int;

    public function getShoppingListHash(): string;

    public function getQuantity(): ?int;

    public function getName(): ?string;

    public function getTaken(): ?bool;

    public function getPositionY(): ?int;
}
