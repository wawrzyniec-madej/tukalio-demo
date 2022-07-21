<?php

declare(strict_types=1);

namespace App\Tests\Api\ShoppingListItem;

use App\DataFixtures\Product\ProductFixtures;
use App\DataFixtures\ShoppingList\ShoppingListNotLockedFixture;
use App\DataFixtures\ShoppingListItem\ShoppingListItemTakenFixture;
use App\Tests\Api\AbstractApiTestCase;
use App\Tests\Api\JsonResponse;
use App\Tests\Api\TypeArrayFlattener;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class PatchShoppingListItemApiTest extends AbstractApiTestCase
{
    public function setUp(): void
    {
        $this->databaseTool->loadFixtures([
            ShoppingListNotLockedFixture::class,
            ShoppingListItemTakenFixture::class,
            ProductFixtures::class
        ]);
    }

    /** @throws Exception|TransportExceptionInterface */
    public function test_patchShoppingListItem_success(): void
    {
        $response = $this->client->request(
            'PATCH',
            sprintf(
                '/api/shoppingList/%s/shoppingListItem/1',
                ShoppingListNotLockedFixture::HASH
            ),
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode([
                    'name' => 'piniakolada',
                    'taken' => true,
                    'positionY' => 500
                ], JSON_THROW_ON_ERROR)
            ]
        );

        $jsonResponse = new JsonResponse($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame(
            [
                'data.id' => 'integer',
                'data.name' => 'piniakolada',
                'data.taken' => true,
                'data.quantity' => 5,
                'data.positionY' => 500
            ],
            (new TypeArrayFlattener())
                ->addTypePath('data.id')
                ->getResult($jsonResponse->getContent())
        );
    }
}
