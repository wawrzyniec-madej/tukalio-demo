<?php

declare(strict_types=1);

namespace App\Dto\ShoppingListItem;

use App\Entity\ShoppingListItem;

final class ShoppingListItemDto implements ShoppingListItemDtoInterface
{
    private ?int $id;
    private string $name;
    private bool $taken;
    private int $quantity;
    private int $positionY;

    public function __construct(ShoppingListItem $shoppingListItem)
    {
        $this->id = $shoppingListItem->getId();
        $this->name = $shoppingListItem->getName();
        $this->taken = $shoppingListItem->isTaken();
        $this->quantity = $shoppingListItem->getQuantity();
        $this->positionY = $shoppingListItem->getPositionY();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'taken' => $this->taken,
            'quantity' => $this->quantity,
            'positionY' => $this->positionY
        ];
    }
}
