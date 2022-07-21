<?php

declare(strict_types=1);

namespace App\Command\ShoppingListItem;

final class PatchShoppingListItemCommand implements PatchShoppingListItemCommandInterface
{
    public function __construct(
        private int $shoppingListItemId,
        private string $shoppingListHash,
        private ?int $quantity,
        private ?string $name,
        private ?bool $taken,
        private ?int $positionY
    ) {
    }

    public function getShoppingListItemId(): int
    {
        return $this->shoppingListItemId;
    }

    public function getShoppingListHash(): string
    {
        return $this->shoppingListHash;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTaken(): ?bool
    {
        return $this->taken;
    }

    public function getPositionY(): ?int
    {
        return $this->positionY;
    }
}
