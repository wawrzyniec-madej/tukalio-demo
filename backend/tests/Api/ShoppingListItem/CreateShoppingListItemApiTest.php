<?php

declare(strict_types=1);

namespace App\Tests\Api\ShoppingListItem;

use App\DataFixtures\ShoppingList\ShoppingListNotLockedFixture;
use App\Tests\Api\AbstractApiTestCase;
use App\Tests\Api\JsonResponse;
use App\Tests\Api\TypeArrayFlattener;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class CreateShoppingListItemApiTest extends AbstractApiTestCase
{
    public function setUp(): void
    {
        $this->databaseTool->loadFixtures([
            ShoppingListNotLockedFixture::class
        ]);
    }

    /** @throws Exception|TransportExceptionInterface */
    public function test_createShoppingListItem_success(): void
    {
        $response = $this->client->request(
            'POST',
            sprintf(
                '/api/shoppingList/%s/shoppingListItem',
                ShoppingListNotLockedFixture::HASH
            ),
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode([
                    'name' => 'pikachu',
                    'quantity' => 20
                ], JSON_THROW_ON_ERROR)
            ]
        );

        $jsonResponse = new JsonResponse($response);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertSame(
            [
                'data.id' => 'integer',
                'data.name' => 'pikachu',
                'data.taken' => false,
                'data.quantity' => 20,
                'data.positionY' => 1
            ],
            (new TypeArrayFlattener())
                ->addTypePath('data.id')
                ->getResult($jsonResponse->getContent())
        );
    }
}
