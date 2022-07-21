<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\HashGenerationException;

interface HashGeneratorServiceInterface
{
    /**
     * @throws HashGenerationException
     */
    public function generateHash(): string;
}
