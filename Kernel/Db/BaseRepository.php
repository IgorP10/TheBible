<?php

namespace Kernel\Db;

use Kernel\Db\Connection\Orchestrator;

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

    protected function findByAll(array $criteria): array
    {
        return $this->getEntityRepository()->findBy($criteria);
    }

    protected function findOneBy(array $criteria): ?object
    {
        return $this->getEntityRepository()->findOneBy($criteria);
    }

    protected function persist(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    protected function remove(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    protected function update(object $entity): void
    {
        $this->getEntityManager()->merge($entity);
        $this->getEntityManager()->flush();
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
