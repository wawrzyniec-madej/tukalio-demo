<?php

declare(strict_types=1);

namespace App\Tests\Api\ShoppingListItem;

use App\DataFixtures\ShoppingList\ShoppingListNotLockedFixture;
use App\DataFixtures\ShoppingListItem\ShoppingListItemTakenFixture;
use App\Tests\Api\AbstractApiTestCase;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class DeleteShoppingListItemApiTest extends AbstractApiTestCase
{
    public function setUp(): void
    {
        $this->databaseTool->loadFixtures([
            ShoppingListNotLockedFixture::class,
            ShoppingListItemTakenFixture::class
        ]);
    }

    /** @throws Exception|TransportExceptionInterface */
    public function test_createShoppingListItem_success(): void
    {
        $response = $this->client->request(
            'DELETE',
            sprintf(
                '/api/shoppingList/%s/shoppingListItem/1',
                ShoppingListNotLockedFixture::HASH
            )
        );

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
