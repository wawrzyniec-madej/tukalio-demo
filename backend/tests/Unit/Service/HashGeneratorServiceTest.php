<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\HashGeneratorService;
use Exception;
use PHPUnit\Framework\TestCase;

final class HashGeneratorServiceTest extends TestCase
{
    private HashGeneratorService $hashGeneratorService;

    public function setUp(): void
    {
        $this->hashGeneratorService = new HashGeneratorService();
    }

    /**
     * @throws Exception
     */
    public function test_generateHash_success(): void
    {
        $hash = $this->hashGeneratorService->generateHash();

        self::assertEquals(
            16,
            strlen($hash)
        );
    }
}
