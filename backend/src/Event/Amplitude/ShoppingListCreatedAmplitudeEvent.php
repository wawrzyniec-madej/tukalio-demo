<?php

declare(strict_types=1);

namespace App\Event\Amplitude;

final class ShoppingListCreatedAmplitudeEvent implements ShoppingListCreatedAmplitudeEventInterface
{
    public function __construct(
        private string $shoppingListName,
        private string $shoppingListHash,
        private int $shoppingListId
    ) {
    }

    public function getBody(): array
    {
        return [
            [
                'user_id' => $this->shoppingListHash,
                'event_type' => 'Shopping List Created',
                'country' => 'Poland',
                'event_properties' => [
                    'shoppingListId' => $this->shoppingListId,
                    'shoppingListHash' => $this->shoppingListHash,
                    'shoppingListName' => $this->shoppingListName
                ]
            ]
        ];
    }
}
