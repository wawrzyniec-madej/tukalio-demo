<?php

declare(strict_types=1);

namespace App\Tests\Unit\CommandHandler\ShoppingListItem;

use App\Command\ShoppingListItem\PatchShoppingListItemCommandInterface;
use App\CommandHandler\ShoppingListItem\PatchShoppingListItemCommandHandler;
use App\CommandHandler\ShoppingListItem\PatchShoppingListItemCommandHandlerInterface;
use App\Container\AmplitudeEventContainerInterface;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;
use App\Factory\Dto\ShoppingListItemDtoFactoryInterface;
use App\Repository\ShoppingListItemRepositoryInterface;
use App\Service\ProductServiceInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class PatchShoppingListItemCommandHandlerTest extends TestCase
{
    private ProductServiceInterface $productService;
    private ShoppingListItemDtoFactoryInterface $shoppingListItemDtoFactory;
    private ShoppingListItemRepositoryInterface $shoppingListItemRepository;
    private PatchShoppingListItemCommandHandlerInterface $patchShoppingListItemCommandHandler;
    private AmplitudeEventContainerInterface $amplitudeEventContainer;

    public function setUp(): void
    {
        $this->shoppingListItemRepository = $this->createMock(ShoppingListItemRepositoryInterface::class);
        $this->shoppingListItemDtoFactory = $this->createMock(ShoppingListItemDtoFactoryInterface::class);
        $this->productService = $this->createMock(ProductServiceInterface::class);
        $this->amplitudeEventContainer = $this->createMock(AmplitudeEventContainerInterface::class);

        $this->patchShoppingListItemCommandHandler = new PatchShoppingListItemCommandHandler(
            $this->shoppingListItemRepository,
            $this->shoppingListItemDtoFactory,
            $this->productService,
            $this->amplitudeEventContainer
        );
    }

    /** @throws Exception */
    public function test_handle_success(): void
    {
        $patchShoppingListItemCommand = $this->createMock(PatchShoppingListItemCommandInterface::class);
        $patchShoppingListItemCommand
            ->method('getName')->willReturn('name');
        $patchShoppingListItemCommand
            ->method('getQuantity')->willReturn(5);
        $patchShoppingListItemCommand
            ->method('getShoppingListHash')->willReturn('hash');
        $patchShoppingListItemCommand
            ->method('getTaken')->willReturn(true);

        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->method('getHash')->willReturn('hash');

        $shoppingListItem = $this->createMock(ShoppingListItem::class);
        $shoppingListItem
            ->method('isTaken')->willReturn(true);
        $shoppingListItem
            ->method('getId')->willReturn(5);
        $shoppingListItem
            ->method('getName')->willReturn('name');
        $shoppingListItem
            ->method('getShoppingList')->willReturn($shoppingList);

        $shoppingListItemDto = $this->createMock(ShoppingListItemDtoInterface::class);

        $this->shoppingListItemRepository
            ->expects($this->once())
            ->method('getShoppingListItemByShoppingListHashAndShoppingListItemId')
            ->with(
                $patchShoppingListItemCommand->getShoppingListHash(),
                $patchShoppingListItemCommand->getShoppingListItemId()
            )
            ->willReturn($shoppingListItem);

        $this->amplitudeEventContainer
            ->expects($this->exactly(2))
            ->method('addEvent');

        $shoppingListItem
            ->expects($this->once())
            ->method('updateName')
            ->with($patchShoppingListItemCommand->getName())
            ->willReturn($shoppingListItem);

        $this->productService
            ->expects($this->once())
            ->method('addToUsedProducts')
            ->with($patchShoppingListItemCommand->getName());

        $shoppingListItem
            ->expects($this->once())
            ->method('updateQuantity')
            ->with($patchShoppingListItemCommand->getQuantity())
            ->willReturn($shoppingListItem);

        $shoppingListItem
            ->expects($this->once())
            ->method('updateTaken')
            ->with($patchShoppingListItemCommand->getTaken())
            ->willReturn($shoppingListItem);

        $this->shoppingListItemRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $shoppingListItem,
                true
            );

        $this->shoppingListItemDtoFactory
            ->expects($this->once())
            ->method('create')
            ->with($shoppingListItem)
            ->willReturn($shoppingListItemDto);

        $result = $this->patchShoppingListItemCommandHandler->handle(
            $patchShoppingListItemCommand
        );

        self::assertEquals(
            $result,
            $shoppingListItemDto
        );
    }
}
