<?php

declare(strict_types=1);

namespace App\Tests\Api\ShoppingList;

use App\DataFixtures\ShoppingList\ShoppingListNotLockedFixture;
use App\Helper\JsonHelper;
use App\Tests\Api\AbstractApiTestCase;
use App\Tests\Api\JsonResponse;
use App\Tests\Api\TypeArrayFlattener;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class PatchShoppingListApiTest extends AbstractApiTestCase
{
    public function setUp(): void
    {
        $this->databaseTool->loadFixtures([
            ShoppingListNotLockedFixture::class
        ]);
    }

    /** @throws Exception|TransportExceptionInterface */
    public function test_patchShoppingList_success(): void
    {
        $newShoppingListName = 'new shopping list name';

        $response = $this->client->request(
            'PATCH',
            sprintf(
                '/api/shoppingList/%s',
                ShoppingListNotLockedFixture::HASH
            ),
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => JsonHelper::encodeArray(
                    [
                        'name' => $newShoppingListName
                    ]
                )
            ]
        );

        $jsonResponse = new JsonResponse($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame(
            [
                'data.hash' => 'defaultShoppingList',
                'data.name' => 'new shopping list name',
                'data.shoppingListItems' => []
            ],
            (new TypeArrayFlattener())
                ->getResult($jsonResponse->getContent())
        );
    }
}
