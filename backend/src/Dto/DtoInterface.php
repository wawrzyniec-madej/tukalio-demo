<?php

declare(strict_types=1);

namespace App\Dto;

interface DtoInterface extends \JsonSerializable
{
    /** @return mixed[] */
    public function jsonSerialize(): array;
}
