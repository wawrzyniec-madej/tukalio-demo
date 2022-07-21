<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Factory\ShoppingListNameFactory;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class ShoppingListNameFactoryTest extends TestCase
{
    private ShoppingListNameFactory $shoppingListNameFactory;

    public function setUp(): void
    {
        $this->shoppingListNameFactory = new ShoppingListNameFactory();
    }

    public function test_create_success(): void
    {
        $result = $this->shoppingListNameFactory->create();

        $nowFormat = (new DateTimeImmutable('now'))->format('d.m');

        self::assertStringContainsString(
            'Lista ' . $nowFormat,
            $result
        );
    }
}
