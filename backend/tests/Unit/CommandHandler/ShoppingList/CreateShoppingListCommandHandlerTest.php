<?php
declare(strict_types=1);

namespace App\Tests\Unit\CommandHandler\ShoppingList;

use App\Command\ShoppingList\CreateShoppingListCommandInterface;
use App\CommandHandler\ShoppingList\CreateShoppingListCommandHandler;
use App\CommandHandler\ShoppingList\CreateShoppingListCommandHandlerInterface;
use App\Container\AmplitudeEventContainerInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Entity\ShoppingList;
use App\Factory\Dto\ShoppingListDtoFactoryInterface;
use App\Factory\Entity\ShoppingListFactoryInterface;
use App\Factory\ShoppingListNameFactoryInterface;
use App\Repository\ShoppingListRepositoryInterface;
use App\Service\HashGeneratorServiceInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class CreateShoppingListCommandHandlerTest extends TestCase
{
    private ShoppingListRepositoryInterface $shoppingListRepository;
    private ShoppingListDtoFactoryInterface $shoppingListDtoFactory;
    private HashGeneratorServiceInterface $hashGeneratorService;
    private ShoppingListFactoryInterface $shoppingListFactory;
    private CreateShoppingListCommandHandlerInterface $createShoppingListCommandHandler;
    private ShoppingListNameFactoryInterface $shoppingListNameFactory;
    private AmplitudeEventContainerInterface $amplitudeEventContainer;

    public function setUp(): void
    {
        $this->shoppingListDtoFactory = $this->createMock(ShoppingListDtoFactoryInterface::class);
        $this->shoppingListFactory = $this->createMock(ShoppingListFactoryInterface::class);
        $this->hashGeneratorService = $this->createMock(HashGeneratorServiceInterface::class);
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);
        $this->shoppingListNameFactory = $this->createMock(ShoppingListNameFactoryInterface::class);
        $this->amplitudeEventContainer = $this->createMock(AmplitudeEventContainerInterface::class);

        $this->createShoppingListCommandHandler = new CreateShoppingListCommandHandler(
            $this->shoppingListFactory,
            $this->hashGeneratorService,
            $this->shoppingListDtoFactory,
            $this->shoppingListRepository,
            $this->shoppingListNameFactory,
            $this->amplitudeEventContainer
        );
    }

    /** @throws Exception */
    public function test_handle_shopping_list_with_hash_already_exists(): void
    {
        $freshHash = 'generatedHash';
        $existingHash = 'existingHash';
        $shoppingListName = 'name';

        $shoppingListDto = $this->createMock(ShoppingListDtoInterface::class);

        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->method('getId')
            ->willReturn(5);
        $shoppingList
            ->method('getName')
            ->willReturn('name');
        $shoppingList
            ->method('getHash')
            ->willReturn('hash');

        $createShoppingListCommand = $this->createMock(CreateShoppingListCommandInterface::class);

        $this->shoppingListNameFactory
            ->method('create')
            ->willReturn($shoppingListName);

        $this->hashGeneratorService
            ->expects($this->exactly(2))
            ->method('generateHash')
            ->willReturnOnConsecutiveCalls($existingHash, $freshHash);

        $this->shoppingListRepository
            ->expects($this->exactly(2))
            ->method('isShoppingListWithHash')
            ->withConsecutive(
                [$existingHash],
                [$freshHash]
            )
            ->will(
                $this->onConsecutiveCalls(
                    true,
                    false
                )
            );

        $this->amplitudeEventContainer
            ->expects($this->once())
            ->method('addEvent');

        $this->shoppingListFactory
            ->expects($this->once())
            ->method('create')
            ->with($freshHash, $shoppingListName)
            ->willReturn($shoppingList);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('save')
            ->with($shoppingList);

        $this->shoppingListDtoFactory
            ->expects($this->once())
            ->method('create')
            ->with($shoppingList)
            ->willReturn($shoppingListDto);

        $this->createShoppingListCommandHandler->handle($createShoppingListCommand);
    }

    /** @throws Exception */
    public function test_handle_shopping_list_with_hash_not_exists(): void
    {
        $freshHash = 'generatedHash';
        $shoppingListName = 'name';

        $shoppingListDto = $this->createMock(ShoppingListDtoInterface::class);

        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->method('getId')
            ->willReturn(5);
        $shoppingList
            ->method('getName')
            ->willReturn('name');
        $shoppingList
            ->method('getHash')
            ->willReturn('hash');

        $createShoppingListCommand = $this->createMock(CreateShoppingListCommandInterface::class);

        $this->shoppingListNameFactory
            ->method('create')
            ->willReturn($shoppingListName);

        $this->hashGeneratorService
            ->expects($this->once())
            ->method('generateHash')
            ->willReturn($freshHash);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('isShoppingListWithHash')
            ->with($freshHash)
            ->willReturn(false);

        $this->amplitudeEventContainer
            ->expects($this->once())
            ->method('addEvent');

        $this->shoppingListFactory
            ->expects($this->once())
            ->method('create')
            ->with($freshHash, $shoppingListName)
            ->willReturn($shoppingList);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('save')
            ->with($shoppingList);

        $this->shoppingListDtoFactory
            ->expects($this->once())
            ->method('create')
            ->with($shoppingList)
            ->willReturn($shoppingListDto);

        $this->createShoppingListCommandHandler->handle($createShoppingListCommand);
    }
}
