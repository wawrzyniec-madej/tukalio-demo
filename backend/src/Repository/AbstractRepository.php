<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractRepository extends ServiceEntityRepository implements AbstractRepositoryInterface
{
    public function remove(EntityInterface $entity): void
    {
        $this->_em->remove($entity);
    }

    public function save(EntityInterface $entity, bool $shouldFlush = false): EntityInterface
    {
        $this->persist($entity);

        if (true === $shouldFlush) {
            $this->flush();
        }

        return $entity;
    }

    public function persist(EntityInterface $entity): void
    {
        $this->_em->persist($entity);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }
}
