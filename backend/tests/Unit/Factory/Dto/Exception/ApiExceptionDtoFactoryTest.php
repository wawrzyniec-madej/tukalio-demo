<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory\Dto\Exception;

use App\Dto\Exception\ApiExceptionDtoInterface;
use App\Factory\Dto\Exception\ApiExceptionDtoFactory;
use App\Factory\Dto\Exception\ApiExceptionDtoFactoryInterface;
use PHPUnit\Framework\TestCase;

final class ApiExceptionDtoFactoryTest extends TestCase
{
    private ApiExceptionDtoFactoryInterface $apiExceptionDtoFactory;

    public function setUp(): void
    {
        $this->apiExceptionDtoFactory = new ApiExceptionDtoFactory();
    }

    public function test_build_success(): void
    {
        $result = $this->apiExceptionDtoFactory->create(
            'type',
            'title',
            'detail'
        );

        self::assertInstanceOf(
            ApiExceptionDtoInterface::class,
            $result
        );
    }
}
