<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator\Command\ShoppingList;

use App\Tests\Unit\Validator\AbstractValidatorTestCase;
use App\Validator\Command\ShoppingList\PatchShoppingListCommandValidator;
use App\Validator\ValidatorInterface;
use Generator;
use Symfony\Component\Validator\Validation;

final class PatchShoppingListCommandValidatorTest extends AbstractValidatorTestCase
{
    private ValidatorInterface $patchShoppingListCommandDataValidator;

    public function setUp(): void
    {
        $this->patchShoppingListCommandDataValidator = new PatchShoppingListCommandValidator(
            Validation::createValidator()
        );
    }

    /** @dataProvider validationErrorsDataProvider */
    public function test_validation_errors(
        array $data,
        int $expectedErrorCount
    ): void {
        $this->validateDataAssertErrorCount(
            $this->patchShoppingListCommandDataValidator,
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

        yield 'with optional data' => [
            '$data' => [
                'shoppingListHash' => 'hash',
                'name' => 'kunegunda'
            ],
            '$expectedErrorCount' => 0
        ];

        yield 'with wrong data' => [
            '$data' => [
                'shoppingListHash' => 1,
                'name' => 2
            ],
            '$expectedErrorCount' => 2
        ];
    }
}
