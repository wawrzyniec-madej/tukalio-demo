<?php

declare(strict_types=1);

namespace App\Tests\Unit\CommandHandler\ShoppingListItem;

use App\Command\ShoppingListItem\CreateShoppingListItemCommandInterface;
use App\CommandHandler\ShoppingListItem\CreateShoppingListItemCommandHandler;
use App\CommandHandler\ShoppingListItem\CreateShoppingListItemCommandHandlerInterface;
use App\Container\AmplitudeEventContainerInterface;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;
use App\Factory\Dto\ShoppingListItemDtoFactoryInterface;
use App\Factory\Entity\ShoppingListItemFactoryInterface;
use App\Repository\ShoppingListItemRepositoryInterface;
use App\Repository\ShoppingListRepositoryInterface;
use App\Service\ProductServiceInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class CreateShoppingListItemCommandHandlerTest extends TestCase
{
    private ShoppingListItemDtoFactoryInterface $shoppingListItemDtoFactory;
    private ShoppingListItemRepositoryInterface $shoppingListItemRepository;
    private ShoppingListItemFactoryInterface $shoppingListItemFactory;
    private ShoppingListRepositoryInterface $shoppingListRepository;
    private ProductServiceInterface $productService;
    private CreateShoppingListItemCommandHandlerInterface $createShoppingListItemCommandHandler;
    private AmplitudeEventContainerInterface $amplitudeEventContainer;

    public function setUp(): void
    {
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);
        $this->shoppingListItemFactory = $this->createMock(ShoppingListItemFactoryInterface::class);
        $this->shoppingListItemRepository = $this->createMock(ShoppingListItemRepositoryInterface::class);
        $this->shoppingListItemDtoFactory = $this->createMock(ShoppingListItemDtoFactoryInterface::class);
        $this->productService = $this->createMock(ProductServiceInterface::class);
        $this->amplitudeEventContainer = $this->createMock(AmplitudeEventContainerInterface::class);

        $this->createShoppingListItemCommandHandler = new CreateShoppingListItemCommandHandler(
            $this->shoppingListRepository,
            $this->shoppingListItemFactory,
            $this->shoppingListItemRepository,
            $this->shoppingListItemDtoFactory,
            $this->productService,
            $this->amplitudeEventContainer
        );
    }

    /** @throws Exception */
    public function test_handle_success(): void
    {
        $createShoppingListItemCommand = $this->createMock(CreateShoppingListItemCommandInterface::class);
        $createShoppingListItemCommand
            ->method('getShoppingListHash')->willReturn('hash');
        $createShoppingListItemCommand
            ->method('getQuantity')->willReturn(5);
        $createShoppingListItemCommand
            ->method('getName')->willReturn('name');

        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->method('getId')->willReturn(5);
        $shoppingList
            ->method('getHash')->willReturn('hash');

        $shoppingListItem = $this->createMock(ShoppingListItem::class);
        $shoppingListItem
            ->method('getId')->willReturn(1);
        $shoppingListItem
            ->method('getName')->willReturn('name');
        $shoppingListItem
            ->method('isTaken')->willReturn(true);
        $shoppingListItem
            ->method('getQuantity')->willReturn(5);

        $shoppingListItemDto = $this->createMock(ShoppingListItemDtoInterface::class);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('getShoppingListByHash')
            ->with($createShoppingListItemCommand->getShoppingListHash())
            ->willReturn($shoppingList);

        $this->shoppingListItemFactory
            ->expects($this->once())
            ->method('create')
            ->with(
                $createShoppingListItemCommand->getQuantity(),
                $shoppingList,
                $createShoppingListItemCommand->getName(),
                false
            )
            ->willReturn($shoppingListItem);

        $this->amplitudeEventContainer
            ->expects($this->once())
            ->method('addEvent');

        $this->productService
            ->expects($this->once())
            ->method('addToUsedProducts')
            ->with(
                $createShoppingListItemCommand->getName()
            );

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

        $result = $this->createShoppingListItemCommandHandler->handle(
            $createShoppingListItemCommand
        );

        self::assertEquals(
            $shoppingListItemDto,
            $result
        );
    }
}
