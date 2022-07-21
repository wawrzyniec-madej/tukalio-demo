<?php
declare(strict_types=1);

namespace App\Tests\Unit\Factory\Command\ShoppingList;

use App\Command\ShoppingList\CreateShoppingListCommandInterface;
use App\Factory\Command\ShoppingList\CreateShoppingListCommandFactory;
use App\Factory\Command\ShoppingList\CreateShoppingListCommandFactoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class CreateShoppingListCommandFactoryTest extends TestCase
{
    private CreateShoppingListCommandFactoryInterface $createShoppingListCommandFactory;

    public function setUp(): void
    {
        $this->createShoppingListCommandFactory = new CreateShoppingListCommandFactory();
    }

    /** @throws Exception */
    public function test_create_success(): void
    {
        $request = $this->createMock(Request::class);

        $result = $this->createShoppingListCommandFactory->createFromRequest(
            $request
        );

        self::assertInstanceOf(
            CreateShoppingListCommandInterface::class,
            $result
        );
    }

}
