<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Collection\Dto\DtoCollectionInterface;
use App\Dto\DtoInterface;
use JsonSerializable;

final class JsonResponseDto implements DtoInterface
{
    private JsonSerializable|DtoCollectionInterface $data;

    public function __construct(JsonSerializable|DtoCollectionInterface $data)
    {
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        return [
            'data' => $this->data
        ];
    }
}
