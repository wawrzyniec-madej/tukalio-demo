<?php

declare(strict_types=1);

namespace App\Event\Amplitude;

final class ShoppingListItemNameUpdatedAmplitudeEvent implements ShoppingListItemNameUpdatedAmplitudeEventInterface
{
    public function __construct(
        private string $shoppingListItemName,
        private string $amplitudeUserId,
        private int $shoppingListItemId
    ) {
    }

    public function getBody(): array
    {
        return [
            [
                'user_id' => $this->amplitudeUserId,
                'event_type' => 'Shopping List Item Name Updated',
                'country' => 'Poland',
                'event_properties' => [
                    'shoppingListItemId' => $this->shoppingListItemId,
                    'shoppingListItemName' => $this->shoppingListItemName,
                ]
            ]
        ];
    }
}
