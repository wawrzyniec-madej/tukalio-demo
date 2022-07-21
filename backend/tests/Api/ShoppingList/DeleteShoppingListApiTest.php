<?php
declare(strict_types=1);

namespace App\Tests\Api\ShoppingList;

use App\DataFixtures\ShoppingList\ShoppingListLockedFixture;
use App\DataFixtures\ShoppingList\ShoppingListNotLockedFixture;
use App\DataFixtures\ShoppingListItem\ShoppingListItemTakenFixture;
use App\Tests\Api\AbstractApiTestCase;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class DeleteShoppingListApiTest extends AbstractApiTestCase
{
    /** @throws Exception|TransportExceptionInterface */
    public function test_deleteShoppingList(): void
    {
        $this->databaseTool->loadFixtures([
            ShoppingListNotLockedFixture::class,
            ShoppingListItemTakenFixture::class
        ]);

        $response = $this->client->request('DELETE', '/api/shoppingList/defaultShoppingList');

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /** @throws Exception|TransportExceptionInterface */
    public function test_deleteShoppingList_cannot_delete_locked_list(): void
    {
        $this->databaseTool->loadFixtures([
            ShoppingListLockedFixture::class,
            ShoppingListItemTakenFixture::class
        ]);

        $response = $this->client->request('DELETE', '/api/shoppingList/lockedList');

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
