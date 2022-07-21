<?php
declare(strict_types=1);

namespace App\Tests\Unit\CommandHandler\ShoppingListItem;

use App\Command\ShoppingListItem\DeleteShoppingListItemCommandInterface;
use App\CommandHandler\ShoppingListItem\DeleteShoppingListItemCommandHandler;
use App\CommandHandler\ShoppingListItem\DeleteShoppingListItemCommandHandlerInterface;
use App\Entity\ShoppingListItem;
use App\Repository\ShoppingListItemRepositoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class DeleteShoppingListItemCommandHandlerTest extends TestCase
{
    private ShoppingListItemRepositoryInterface $shoppingListItemRepository;
    private DeleteShoppingListItemCommandHandlerInterface $deleteShoppingListItemCommandHandler;

    public function setUp(): void
    {
        $this->shoppingListItemRepository = $this->createMock(ShoppingListItemRepositoryInterface::class);

        $this->deleteShoppingListItemCommandHandler = new DeleteShoppingListItemCommandHandler(
            $this->shoppingListItemRepository
        );
    }

    /** @throws Exception */
    public function test_handle_success(): void
    {
        $deleteShoppingListItemCommand = $this->createMock(DeleteShoppingListItemCommandInterface::class);
        $deleteShoppingListItemCommand
            ->method('getShoppingListHash')->willReturn('hash');
        $deleteShoppingListItemCommand
            ->method('getShoppingListItemId')->willReturn(5);

        $shoppingListItem = $this->createMock(ShoppingListItem::class);

        $this->shoppingListItemRepository
            ->expects($this->once())
            ->method('getShoppingListItemByShoppingListHashAndShoppingListItemId')
            ->with(
                $deleteShoppingListItemCommand->getShoppingListHash(),
                $deleteShoppingListItemCommand->getShoppingListItemId()
            )
            ->willReturn($shoppingListItem);

        $this->shoppingListItemRepository
            ->expects($this->once())
            ->method('remove')
            ->with($shoppingListItem);

        $this->shoppingListItemRepository
            ->expects($this->once())
            ->method('flush');

        $this->deleteShoppingListItemCommandHandler->handle(
            $deleteShoppingListItemCommand
        );
    }
}
