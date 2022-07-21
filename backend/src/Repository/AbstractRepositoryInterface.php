<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityInterface;

interface AbstractRepositoryInterface
{
    public function persist(EntityInterface $entity): void;

    public function remove(EntityInterface $entity): void;

    public function flush(): void;

    public function save(EntityInterface $entity, bool $shouldFlush = false): EntityInterface;
}
