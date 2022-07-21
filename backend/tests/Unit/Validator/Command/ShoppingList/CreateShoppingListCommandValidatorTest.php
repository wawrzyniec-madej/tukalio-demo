<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator\Command\ShoppingList;

use App\Tests\Unit\Validator\AbstractValidatorTestCase;
use App\Validator\Command\ShoppingList\CreateShoppingListCommandValidator;
use App\Validator\ValidatorInterface;
use Generator;
use Symfony\Component\Validator\Validation;

final class CreateShoppingListCommandValidatorTest extends AbstractValidatorTestCase
{
    private ValidatorInterface $createShoppingListCommandDataValidator;

    public function setUp(): void
    {
        $this->createShoppingListCommandDataValidator = new CreateShoppingListCommandValidator(
            Validation::createValidator()
        );
    }

    /** @dataProvider validationErrorsDataProvider */
    public function test_validation_errors(
        array $data,
        int $expectedErrorCount
    ): void {
        $this->validateDataAssertErrorCount(
            $this->createShoppingListCommandDataValidator,
            $data,
            $expectedErrorCount
        );
    }

    public function validationErrorsDataProvider(): Generator
    {
        yield 'missing data' => [
            '$data' => [],
            '$expectedErrorCount' => 1
        ];

        yield 'ok' => [
            '$data' => [
                'name' => 'kunegunda'
            ],
            '$expectedErrorCount' => 0
        ];

        yield 'invalid data values' => [
            '$data' => [
                'name' => 123
            ],
            '$expectedErrorCount' => 1
        ];
    }
}
