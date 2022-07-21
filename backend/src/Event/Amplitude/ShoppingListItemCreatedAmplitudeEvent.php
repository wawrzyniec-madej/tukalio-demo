<?php

declare(strict_types=1);

namespace App\Event\Amplitude;

final class ShoppingListItemCreatedAmplitudeEvent implements ShoppingListItemCreatedAmplitudeEventInterface
{
    public function __construct(
        private int $shoppingListItemId,
        private string $shoppingListItemName,
        private bool $shoppingListItemTaken,
        private int $shoppingListItemQuantity,
        private string $amplitudeUserId,
        private int $shoppingListId,
    ) {
    }

    public function getBody(): array
    {
        return [
            [
                'user_id' => $this->amplitudeUserId,
                'event_type' => 'Shopping List Item Created',
                'country' => 'Poland',
                'event_properties' => [
                    'shoppingListId' => $this->shoppingListId,
                    'shoppingListItemId' => $this->shoppingListItemId,
                    'shoppingListItemName' => $this->shoppingListItemName,
                    'shoppingListItemTaken' => $this->shoppingListItemTaken,
                    'shoppingListItemQuantity' => $this->shoppingListItemQuantity,
                ]
            ]
        ];
    }
}
