<?php
declare(strict_types=1);

namespace App\Tests\Unit\Factory\Command\ShoppingListItem;

use App\Command\ShoppingListItem\DeleteShoppingListItemCommandInterface;
use App\Factory\Command\ShoppingListItem\DeleteShoppingListItemCommandFactory;
use App\Factory\Command\ShoppingListItem\DeleteShoppingListItemCommandFactoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class DeleteShoppingListItemCommandFactoryTest extends TestCase
{
    private DeleteShoppingListItemCommandFactoryInterface $deleteShoppingListItemCommandFactory;

    public function setUp(): void
    {
        $this->deleteShoppingListItemCommandFactory = new DeleteShoppingListItemCommandFactory();
    }

    /** @throws Exception */
    public function test_create_success(): void
    {
        $result = $this->deleteShoppingListItemCommandFactory->create(
            'hash',
            5
        );

        self::assertInstanceOf(
            DeleteShoppingListItemCommandInterface::class,
            $result
        );
    }
}
