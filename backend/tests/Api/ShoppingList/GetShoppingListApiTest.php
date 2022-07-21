<?php
declare(strict_types=1);

namespace App\Tests\Api\ShoppingList;

use App\DataFixtures\ShoppingList\ShoppingListNotLockedFixture;
use App\DataFixtures\ShoppingListItem\ShoppingListItemTakenFixture;
use App\DataFixtures\ShoppingListItem\ShoppingListItemWithPositionFiveFixture;
use App\Tests\Api\AbstractApiTestCase;
use App\Tests\Api\JsonResponse;
use App\Tests\Api\TypeArrayFlattener;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class GetShoppingListApiTest extends AbstractApiTestCase
{
    public function setUp(): void
    {
        $this->databaseTool->loadFixtures([
            ShoppingListNotLockedFixture::class,
            ShoppingListItemWithPositionFiveFixture::class,
            ShoppingListItemTakenFixture::class,
        ]);
    }

    /** @throws Exception|TransportExceptionInterface */
    public function test_getShoppingList(): void
    {
        $response = $this->client->request(
            'GET',
            sprintf(
                '/api/shoppingList/%s',
                ShoppingListNotLockedFixture::HASH
            )
        );

        $jsonResponse = new JsonResponse($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame(
            [
                'data.hash' => 'defaultShoppingList',
                'data.name' => 'name',
                'data.shoppingListItems.0.id' => 2,
                'data.shoppingListItems.0.name' => 'potato',
                'data.shoppingListItems.0.taken' => true,
                'data.shoppingListItems.0.quantity' => 5,
                'data.shoppingListItems.0.positionY' => 1,
                'data.shoppingListItems.1.id' => 1,
                'data.shoppingListItems.1.name' => 'name',
                'data.shoppingListItems.1.taken' => false,
                'data.shoppingListItems.1.quantity' => 1,
                'data.shoppingListItems.1.positionY' => 5,
            ],
            (new TypeArrayFlattener())
                ->getResult($jsonResponse->getContent())
        );
    }
}
