<?php

declare(strict_types=1);

namespace App\Event\Amplitude;

final class ShoppingListUpdateStartedAmplitudeEvent implements ShoppingListUpdateStartedAmplitudeEventInterface
{
    public function __construct(
        private string $shoppingListHash,
        private int $shoppingListId
    ) {
    }

    public function getBody(): array
    {
        return [
            [
                'user_id' => $this->shoppingListHash,
                'event_type' => 'Shopping List Update Started',
                'country' => 'Poland',
                'event_properties' => [
                    'shoppingListId' => $this->shoppingListId
                ]
            ]
        ];
    }
}
