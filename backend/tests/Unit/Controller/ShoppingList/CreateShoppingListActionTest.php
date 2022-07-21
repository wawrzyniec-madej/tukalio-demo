<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\ShoppingList;

use App\Command\ShoppingList\CreateShoppingListCommandInterface;
use App\CommandHandler\ShoppingList\CreateShoppingListCommandHandlerInterface;
use App\Controller\ShoppingList\CreateShoppingListAction;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Factory\Command\ShoppingList\CreateShoppingListCommandFactoryInterface;
use App\Helper\JsonHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateShoppingListActionTest extends TestCase
{
    private CreateShoppingListCommandHandlerInterface $createShoppingListCommandHandler;
    private CreateShoppingListCommandFactoryInterface $createShoppingListCommandFactory;

    private CreateShoppingListAction $createShoppingListAction;

    public function setUp(): void
    {
        $this->createShoppingListCommandHandler = $this->createMock(CreateShoppingListCommandHandlerInterface::class);
        $this->createShoppingListCommandFactory = $this->createMock(CreateShoppingListCommandFactoryInterface::class);

        $this->createShoppingListAction = new CreateShoppingListAction(
            $this->createShoppingListCommandHandler,
            $this->createShoppingListCommandFactory
        );
    }

    /** @throws Exception
     */
    public function test_invoke_success(): void
    {
        $request = $this->createMock(Request::class);

        $createShoppingListCommand = $this->createMock(CreateShoppingListCommandInterface::class);

        $shoppingListDto = $this->createMock(ShoppingListDtoInterface::class);
        $shoppingListDto
            ->method('jsonSerialize')
            ->willReturn(['serialized']);

        $this->createShoppingListCommandFactory
            ->expects($this->once())
            ->method('createFromRequest')
            ->with($request)
            ->willReturn($createShoppingListCommand);

        $this->createShoppingListCommandHandler
            ->expects($this->once())
            ->method('handle')
            ->with($createShoppingListCommand)
            ->willReturn($shoppingListDto);

        $response = ($this->createShoppingListAction)(
            $request
        );

        self::assertEquals(
            Response::HTTP_CREATED,
            $response->getStatusCode()
        );

        self::assertEquals(
            [
                'data' => ['serialized']
            ],
            JsonHelper::decodeJson($response->getContent())
        );
    }
}
