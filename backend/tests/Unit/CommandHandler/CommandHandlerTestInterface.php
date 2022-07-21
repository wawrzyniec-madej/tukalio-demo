<?php

declare(strict_types=1);

namespace App\Tests\Unit\CommandHandler;

interface CommandHandlerTestInterface
{
    public function test_handle_success(): void;
}
