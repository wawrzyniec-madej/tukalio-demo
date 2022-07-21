<?php

declare(strict_types=1);

namespace App\Tests\Api\ShoppingList;

use App\DataFixtures\ShoppingList\ShoppingListNotLockedFixture;
use App\Tests\Api\AbstractApiTestCase;
use App\Tests\Api\JsonResponse;
use App\Tests\Api\TypeArrayFlattener;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class ChangeShoppingListHashApiTest extends AbstractApiTestCase
{
    public function setUp(): void
    {
        $this->databaseTool->loadFixtures([
            ShoppingListNotLockedFixture::class
        ]);
    }

    /** @throws Exception|TransportExceptionInterface */
    public function test_changeShoppingListHash(): void
    {
        $response = $this->client->request(
            'POST',
            sprintf(
                '/api/shoppingList/%s/changeHash',
                ShoppingListNotLockedFixture::HASH
            )
        );

        $jsonResponse = new JsonResponse($response);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame(
            [
                'data.hash' => 'string',
                'data.name' => 'name',
                'data.shoppingListItems' => 'array'
            ],
            (new TypeArrayFlattener())
                ->addTypePath('data.hash')
                ->addTypePath('data.shoppingListItems')
                ->getResult($jsonResponse->getContent())
        );
    }
}
