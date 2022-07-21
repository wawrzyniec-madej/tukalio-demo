<?php

declare(strict_types=1);

namespace App\Tests\Database;

use App\DataFixtures\ShoppingList\ShoppingListNotLockedFixture;
use App\DataFixtures\ShoppingListItem\ShoppingListItemTakenFixture;
use App\Exception\Entity\ShoppingListItemNotFoundException;
use App\Repository\ShoppingListItemRepository;
use App\Repository\ShoppingListItemRepositoryInterface;
use Exception;

final class ShoppingListItemRepositoryTest extends AbstractDatabaseTestCase
{
    private ShoppingListItemRepositoryInterface $shoppingListItemRepository;

    public function setUp(): void
    {
        $this->shoppingListItemRepository = self::getContainer()->get(ShoppingListItemRepository::class);

        $this->databaseTool->loadFixtures([
            ShoppingListNotLockedFixture::class,
            ShoppingListItemTakenFixture::class
        ]);
    }

    /** @throws Exception */
    public function test_getShoppingListItemByShoppingListHashAndShoppingListItemId_success(): void
    {
        $shoppingListItem = $this->shoppingListItemRepository->getShoppingListItemByShoppingListHashAndShoppingListItemId(
            ShoppingListNotLockedFixture::HASH,
            1
        );

        self::assertNotNull($shoppingListItem);
    }

    /** @throws Exception */
    public function test_getShoppingListItemByShoppingListHashAndShoppingListItemId_not_found_exception(): void
    {
        $this->expectException(ShoppingListItemNotFoundException::class);

        $this->shoppingListItemRepository->getShoppingListItemByShoppingListHashAndShoppingListItemId(
            ShoppingListNotLockedFixture::HASH,
            1000
        );
    }
}
