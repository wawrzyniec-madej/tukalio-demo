<?php

declare(strict_types=1);

namespace App\Dto\Exception;

final class ApiExceptionDto implements ApiExceptionDtoInterface
{
    public function __construct(
        private string $type,
        private string $title,
        private string $detail
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'detail' => $this->detail
        ];
    }
}
