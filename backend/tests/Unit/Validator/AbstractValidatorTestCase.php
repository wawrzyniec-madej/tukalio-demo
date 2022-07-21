<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator;

use App\Exception\ValidationException;
use App\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractValidatorTestCase extends TestCase implements ValidatorTestCaseInterface
{
    public function validateDataAssertErrorCount(
        ValidatorInterface $validator,
        array $data,
        int $expectedErrorCount
    ): void {
        $errorCount = 0;

        try {
            $validator->validate($data);
        } catch (ValidationException $e) {
            $errorCount = $e->getConstraintViolationList()->count();
        }

        self::assertEquals($expectedErrorCount, $errorCount);
    }
}
