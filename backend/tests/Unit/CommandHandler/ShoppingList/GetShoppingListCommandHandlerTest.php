<?php

declare(strict_types=1);

namespace App\Tests\Unit\CommandHandler\ShoppingList;

use App\Command\ShoppingList\GetShoppingListCommandInterface;
use App\CommandHandler\ShoppingList\GetShoppingListCommandHandler;
use App\CommandHandler\ShoppingList\GetShoppingListCommandHandlerInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Entity\ShoppingList;
use App\Factory\Dto\ShoppingListDtoFactoryInterface;
use App\Repository\ShoppingListRepositoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class GetShoppingListCommandHandlerTest extends TestCase
{
    private ShoppingListDtoFactoryInterface $shoppingListDtoFactory;
    private ShoppingListRepositoryInterface $shoppingListRepository;
    private GetShoppingListCommandHandlerInterface $getShoppingListCommandHandler;

    public function setUp(): void
    {
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);
        $this->shoppingListDtoFactory = $this->createMock(ShoppingListDtoFactoryInterface::class);

        $this->getShoppingListCommandHandler = new GetShoppingListCommandHandler(
            $this->shoppingListRepository,
            $this->shoppingListDtoFactory
        );
    }

    /** @throws Exception
     */
    public function test_handle_success(): void
    {
        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->method('getHash')->willReturn('hash');

        $getShoppingListCommand = $this->createMock(GetShoppingListCommandInterface::class);
        $getShoppingListCommand
            ->method('getShoppingListHash')->willReturn($shoppingList->getHash());

        $shoppingListDto = $this->createMock(ShoppingListDtoInterface::class);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('getShoppingListByHash')
            ->with($shoppingList->getHash())
            ->willReturn($shoppingList);

        $this->shoppingListDtoFactory
            ->expects($this->once())
            ->method('create')
            ->with($shoppingList)
            ->willReturn($shoppingListDto);

        $result = $this->getShoppingListCommandHandler->handle(
            $getShoppingListCommand
        );

        self::assertEquals(
            $shoppingListDto,
            $result
        );
    }
}
