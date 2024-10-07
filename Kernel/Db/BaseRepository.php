<?php

namespace Kernel\Db;

use Kernel\Db\Connection\Orchestrator;
use Kernel\Utility\Entity;

abstract class BaseRepository extends Orchestrator
{
    abstract protected function getEntity(): string;

    protected function connectionName(): string
    {
        return 'default';
    }

    protected function findById(int $id): ?object
    {
        return $this->getEntityManager()->find($this->getEntity(), $id);
    }

    protected function findAll(): array
    {
        return $this->getEntityRepository()->findAll();
    }

    protected function findByFilters(array $filters = [], ?array $orderBy = null, ?int $limit = null, ?int $page = 1): array
    {
        return $this->getEntityRepository()
            ->findBy(
                $filters,
                $orderBy,
                $limit,
                $this->setPage($page, $limit)
            );
    }

    protected function setPage(?int $page = 1, ?int $limit = null)
    {
        if (is_null($limit)) {
            return 0;
        }

        return (int) ($page - 1) * $limit;
    }

    protected function findOneBy(array $filters): ?object
    {
        return $this->getEntityRepository()->findOneBy($filters);
    }

    protected function persist(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    protected function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    protected function save(object $entity): object
    {
        $this->transactional(function (self $repository) use ($entity) {
            $repository->persist($entity);
            $repository->flush();
        });

        return $entity;
    }

    protected function transactional(callable $callback): mixed
    {
        $this->beginTransaction();
        try {

            $result = $callback($this);
            $this->commit();

            return $result;
        } catch (\Throwable $e) {
            $this->rollback();
            throw $e;
        }
    }

    protected function beginTransaction(): void
    {
        $this->getEntityManager()->beginTransaction();
    }

    protected function rollback(): void
    {
        $this->getEntityManager()->rollback();
    }

    protected function commit(): void
    {
        $this->getEntityManager()->commit();
    }

    protected function remove(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    protected function clear(): void
    {
        $this->getEntityManager()->clear();
    }

    public function createEntity(): Entity
    {
        return new ($this->getEntity());
    }

    public function getReference(string $entity, int $id): ?Entity
    {
        return $this->getEntityManager()->getReference($entity, $id);
    }

    protected function getEntityRepository(): \Doctrine\ORM\EntityRepository
    {
        return $this->getEntityManager()->getRepository($this->getEntity());
    }

    protected function getQueryBuilder(): \Doctrine\ORM\QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder();
    }
}
