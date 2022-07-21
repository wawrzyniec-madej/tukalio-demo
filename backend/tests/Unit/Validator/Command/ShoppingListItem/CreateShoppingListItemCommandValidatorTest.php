<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator\Command\ShoppingListItem;

use App\Tests\Unit\Validator\AbstractValidatorTestCase;
use App\Validator\Command\ShoppingListItem\CreateShoppingListItemCommandValidator;
use App\Validator\ValidatorInterface;
use Generator;
use Symfony\Component\Validator\Validation;

final class CreateShoppingListItemCommandValidatorTest extends AbstractValidatorTestCase
{
    private ValidatorInterface $createShoppingListItemCommandDataValidator;

    public function setUp(): void
    {
        $this->createShoppingListItemCommandDataValidator = new CreateShoppingListItemCommandValidator(
            Validation::createValidator()
        );
    }

    /** @dataProvider validationErrorsDataProvider */
    public function test_validation_errors(
        array $data,
        int $expectedErrorCount
    ): void {
        $this->validateDataAssertErrorCount(
            $this->createShoppingListItemCommandDataValidator,
            $data,
            $expectedErrorCount
        );
    }

    public function validationErrorsDataProvider(): Generator
    {
        yield 'ok' => [
            '$data' => [
                'shoppingListHash' => 'hash',
                'name' => 'kunegunda',
                'quantity' => 5
            ],
            '$expectedErrorCount' => 0
        ];

        yield 'missing data' => [
            '$data' => [],
            '$expectedErrorCount' => 3
        ];

        yield 'invalid data values' => [
            '$data' => [
                'shoppingListHash' => 123,
                'name' => 123,
                'quantity' => 150
            ],
            '$expectedErrorCount' => 3
        ];
    }
}
