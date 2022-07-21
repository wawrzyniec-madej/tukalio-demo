<?php

declare(strict_types=1);

namespace App\Tests\Unit\Collection;

use App\Collection\Entity\ShoppingListItemCollection;
use App\Entity\ShoppingListItem;
use App\Exception\InvalidCollectionElementTypeException;
use Exception;
use PHPUnit\Framework\TestCase;

final class ObjectCollectionTest extends TestCase
{
    public function test_empty_collection_length(): void
    {
        $objectCollection = new ShoppingListItemCollection();

        self::assertEquals(0, $objectCollection->count());
    }

    public function test_invalid_collection_element_type(): void
    {
        $this->expectException(InvalidCollectionElementTypeException::class);

        $objectCollection = new ShoppingListItemCollection();

        $objectCollection->add(1);
    }

    /** @throws Exception */
    public function test_collection_success(): void
    {
        $objectCollection = new ShoppingListItemCollection();

        $shoppingListItem = $this->createMock(ShoppingListItem::class);

        $objectCollection->add($shoppingListItem);

        self::assertEquals(1, $objectCollection->count());
    }
}
