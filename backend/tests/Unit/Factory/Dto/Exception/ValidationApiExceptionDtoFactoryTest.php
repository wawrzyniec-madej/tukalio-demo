<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory\Dto\Exception;

use App\Dto\Exception\ValidationApiExceptionDtoInterface;
use App\Factory\Dto\Exception\ValidationApiExceptionDtoFactory;
use App\Factory\Dto\Exception\ValidationApiExceptionDtoFactoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationApiExceptionDtoFactoryTest extends TestCase
{
    private ValidationApiExceptionDtoFactoryInterface $validationApiExceptionDtoFactory;

    public function setUp(): void
    {
        $this->validationApiExceptionDtoFactory = new ValidationApiExceptionDtoFactory();
    }

    public function test_build_success(): void
    {
        $result = $this->validationApiExceptionDtoFactory->create(
            'type',
            'title',
            'detail',
            $this->createMock(ConstraintViolationListInterface::class)
        );

        self::assertInstanceOf(
            ValidationApiExceptionDtoInterface::class,
            $result
        );
    }
}
