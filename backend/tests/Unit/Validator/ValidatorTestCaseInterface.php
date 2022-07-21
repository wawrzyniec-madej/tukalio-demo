<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator;

use Generator;

interface ValidatorTestCaseInterface
{
    public function test_validation_errors(
        array $data,
        int $expectedErrorCount
    ): void;

    public function validationErrorsDataProvider(): Generator;
}
