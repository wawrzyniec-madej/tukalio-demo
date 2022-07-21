<?php

declare(strict_types=1);

namespace App\Factory;

use DateTimeImmutable;

final class ShoppingListNameFactory implements ShoppingListNameFactoryInterface
{
    public function create(): string
    {
        $now = new DateTimeImmutable('now');

        return 'Lista ' . $now->format('d.m');
    }
}
