<?php

namespace Kernel\Db\Connection;

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

abstract class Orchestrator
{
    private EntityManager $entityManager;

    protected static array|null $connection = null;

    abstract protected function connectionName(): string;

    protected function getEntityManager(): EntityManager
    {
        if (!isset($this->entityManager)) {
            $this->entityManager = new EntityManager(
                $this->getDriverManager(),
                $this->getDoctrineConfiguration()
            );
        }

        return $this->entityManager;
    }

    public function getDriverManager(): \Doctrine\DBAL\Connection
    {
        $connection = $this->getConnection();

        if (!isset(self::$connection[$this->connectionName()])) {
            self::$connection[$this->connectionName()] = DriverManager::getConnection(
                [
                    'driver' => $connection->getDriver(),
                    'host' => $connection->getHost(),
                    'port' => $connection->getPort(),
                    'user' => $connection->getUsername(),
                    'password' => $connection->getPassword(),
                    'dbname' => $connection->getDatabase(),
                    'charset' => $connection->getCharset()
                ],
                $this->getDoctrineConfiguration()
            );
        }

        return self::$connection[$this->connectionName()];
    }

    private function getConnection(): Connection
    {
        return container()->make(ConnectionHandler::class, [
            'connectionName' => $this->connectionName()
        ])->getConnection();
    }

    private function getDoctrineConfiguration(): Configuration
    {
        return ORMSetup::createAttributeMetadataConfiguration(
            [ROOT_PATH . '/App'],
            true
        );
    }
}
