<?php

declare(strict_types=1);

namespace App\Tests\Unit\CommandHandler\ShoppingList;

use App\Command\ShoppingList\DeleteShoppingListCommandInterface;
use App\CommandHandler\ShoppingList\DeleteShoppingListCommandHandler;
use App\CommandHandler\ShoppingList\DeleteShoppingListCommandHandlerInterface;
use App\Entity\ShoppingList;
use App\Exception\Entity\ShoppingListIsLockedException;
use App\Repository\ShoppingListRepositoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class DeleteShoppingListCommandHandlerTest extends TestCase
{
    private ShoppingListRepositoryInterface $shoppingListRepository;
    private DeleteShoppingListCommandHandlerInterface $deleteShoppingListCommandHandler;

    public function setUp(): void
    {
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);
        $this->deleteShoppingListCommandHandler = new DeleteShoppingListCommandHandler(
            $this->shoppingListRepository
        );
    }

    /** @throws Exception */
    public function test_handle_success(): void
    {
        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->method('getHash')
            ->willReturn('hash');

        $deleteShoppingListCommand = $this->createMock(DeleteShoppingListCommandInterface::class);
        $deleteShoppingListCommand
            ->method('getShoppingListHash')
            ->willReturn($shoppingList->getHash());

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('getShoppingListByHash')
            ->with($shoppingList->getHash())
            ->willReturn($shoppingList);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('remove')
            ->with($shoppingList);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('flush');

        $this->deleteShoppingListCommandHandler->handle(
            $deleteShoppingListCommand
        );
    }

    /** @throws Exception */
    public function test_handle_shopping_list_is_locked_exception(): void
    {
        $this->expectException(ShoppingListIsLockedException::class);

        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->method('getHash')
            ->willReturn('hash');
        $shoppingList
            ->method('isLocked')
            ->willReturn(true);

        $deleteShoppingListCommand = $this->createMock(DeleteShoppingListCommandInterface::class);
        $deleteShoppingListCommand
            ->method('getShoppingListHash')
            ->willReturn($shoppingList->getHash());

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('getShoppingListByHash')
            ->with($shoppingList->getHash())
            ->willReturn($shoppingList);

        $this->deleteShoppingListCommandHandler->handle(
            $deleteShoppingListCommand
        );
    }
}
