<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator\Command\ShoppingListItem;

use App\Tests\Unit\Validator\AbstractValidatorTestCase;
use App\Validator\Command\ShoppingListItem\PatchShoppingListItemCommandValidator;
use App\Validator\ValidatorInterface;
use Generator;
use Symfony\Component\Validator\Validation;

final class PatchShoppingListItemCommandValidatorTest extends AbstractValidatorTestCase
{
    private ValidatorInterface $patchShoppingListItemCommandValidator;

    public function setUp(): void
    {
        $this->patchShoppingListItemCommandValidator = new PatchShoppingListItemCommandValidator(
            Validation::createValidator()
        );
    }

    /** @dataProvider validationErrorsDataProvider */
    public function test_validation_errors(
        array $data,
        int $expectedErrorCount
    ): void {
        $this->validateDataAssertErrorCount(
            $this->patchShoppingListItemCommandValidator,
            $data,
            $expectedErrorCount
        );
    }

    public function validationErrorsDataProvider(): Generator
    {
        yield 'missing data' => [
            '$data' => [],
            '$expectedErrorCount' => 2
        ];

        yield 'with optional data' => [
            '$data' => [
                'shoppingListItemId' => 5,
                'shoppingListHash' => 'hash',
                'name' => 'abba',
                'quantity' => 5,
                'taken' => false,
                'positionY' => 100
            ],
            '$expectedErrorCount' => 0
        ];

        yield 'with wrong data' => [
            '$data' => [
                'shoppingListItemId' => [],
                'shoppingListHash' => 3,
                'name' => 123,
                'quantity' => '5',
                'taken' => [],
                'positionY' => '111'
            ],
            '$expectedErrorCount' => 6
        ];
    }
}
