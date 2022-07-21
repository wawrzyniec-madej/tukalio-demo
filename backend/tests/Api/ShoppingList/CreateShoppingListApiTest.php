<?php
declare(strict_types=1);

namespace App\Tests\Api\ShoppingList;

use App\Tests\Api\AbstractApiTestCase;
use App\Tests\Api\JsonResponse;
use App\Tests\Api\TypeArrayFlattener;
use DateTimeImmutable;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class CreateShoppingListApiTest extends AbstractApiTestCase
{
    /** @throws Exception|TransportExceptionInterface */
    public function test_createShoppingList(): void
    {
        $response = $this->client->request('POST', '/api/shoppingList', [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $jsonResponse = new JsonResponse($response);

        $nowFormat = (new DateTimeImmutable())->format('d.m');
        $expectedShoppingListName = 'Lista ' . $nowFormat;

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertSame(
            [
                'data.hash' => 'string',
                'data.name' => $expectedShoppingListName,
                'data.shoppingListItems' => 'array'
            ],
            (new TypeArrayFlattener())
                ->addTypePath('data.hash')
                ->addTypePath('data.shoppingListItems')
                ->getResult($jsonResponse->getContent())
        );
    }
}
