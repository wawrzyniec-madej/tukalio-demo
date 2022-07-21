<?php

declare(strict_types=1);

namespace App\Tests\Database;

use App\DataFixtures\ShoppingList\ShoppingListNotLockedFixture;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Repository\ShoppingListRepository;
use App\Repository\ShoppingListRepositoryInterface;
use Exception;

final class ShoppingListRepositoryTest extends AbstractDatabaseTestCase
{
    private ShoppingListRepositoryInterface $shoppingListRepository;

    public function setUp(): void
    {
        $shoppingListRepository = self::getContainer()->get(ShoppingListRepository::class);
        if (!$shoppingListRepository instanceof ShoppingListRepositoryInterface) {
            throw new \RuntimeException('Shopping list repository error');
        }

        $this->shoppingListRepository = $shoppingListRepository;

        $this->databaseTool->loadFixtures([
            ShoppingListNotLockedFixture::class
        ]);
    }

    /** @throws Exception */
    public function test_getShoppingListByHash_success(): void
    {
        $shoppingList = $this->shoppingListRepository->getShoppingListByHash(ShoppingListNotLockedFixture::HASH);

        self::assertNotNull($shoppingList);
    }

    /** @throws Exception */
    public function test_getShoppingListByHash_not_found_exception(): void
    {
        $this->expectException(ShoppingListNotFoundException::class);

        $this->shoppingListRepository->getShoppingListByHash('');
    }

    /** @throws Exception */
    public function test_isShoppingListWithHash_true(): void
    {
        $isShoppingList = $this->shoppingListRepository->isShoppingListWithHash(ShoppingListNotLockedFixture::HASH);

        self::assertTrue($isShoppingList);
    }

    /** @throws Exception */
    public function test_isShoppingListWithHash_false(): void
    {
        $isShoppingList = $this->shoppingListRepository->isShoppingListWithHash('');

        self::assertFalse($isShoppingList);
    }
}
