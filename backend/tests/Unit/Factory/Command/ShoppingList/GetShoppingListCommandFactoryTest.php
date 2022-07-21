<?php
declare(strict_types=1);

namespace App\Tests\Unit\Factory\Command\ShoppingList;

use App\Command\ShoppingList\GetShoppingListCommandInterface;
use App\Factory\Command\ShoppingList\GetShoppingListCommandFactory;
use App\Factory\Command\ShoppingList\GetShoppingListCommandFactoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class GetShoppingListCommandFactoryTest extends TestCase
{
    private GetShoppingListCommandFactoryInterface $getShoppingListCommandFactory;

    public function setUp(): void
    {
        $this->getShoppingListCommandFactory = new GetShoppingListCommandFactory();
    }

    /** @throws Exception */
    public function test_create_success(): void
    {
        $result = $this->getShoppingListCommandFactory->create('hash');

        self::assertInstanceOf(
            GetShoppingListCommandInterface::class,
            $result
        );
    }

}
