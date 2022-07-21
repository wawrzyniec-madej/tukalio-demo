<?php
declare(strict_types=1);

namespace App\Tests\Unit\Factory\Command\ShoppingListItem;

use App\Command\ShoppingListItem\PatchShoppingListItemCommandInterface;
use App\Factory\Command\ShoppingListItem\PatchShoppingListItemCommandFactory;
use App\Factory\Command\ShoppingListItem\PatchShoppingListItemCommandFactoryInterface;
use App\Validator\Command\ShoppingListItem\PatchShoppingListItemCommandValidatorInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class PatchShoppingListItemCommandFactoryTest extends TestCase
{
    private PatchShoppingListItemCommandValidatorInterface $patchShoppingListItemCommandValidator;
    private PatchShoppingListItemCommandFactoryInterface $patchShoppingListItemCommandFactory;

    public function setUp(): void
    {
        $this->patchShoppingListItemCommandValidator = $this->createMock(PatchShoppingListItemCommandValidatorInterface::class);

        $this->patchShoppingListItemCommandFactory = new PatchShoppingListItemCommandFactory(
            $this->patchShoppingListItemCommandValidator
        );
    }

    /** @throws Exception */
    public function test_create_success(): void
    {
        $request = new Request(
            [],
            [],
            [
                '_route_params' => [
                    'shoppingListHash' => 'hash',
                    'shoppingListItemId' => '1'
                ]
            ]
        );

        $result = $this->patchShoppingListItemCommandFactory->createFromRequest(
            $request
        );

        self::assertInstanceOf(
            PatchShoppingListItemCommandInterface::class,
            $result
        );
    }
}
