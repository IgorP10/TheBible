<?php

namespace Kernel\Db\Connection;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Symfony\Component\Cache\Adapter\RedisAdapter;

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
        $config = new Configuration();

        // Configura o driver de metadados usando attributes
        $driverImpl = new AttributeDriver([ROOT_PATH . '/App']);
        $config->setMetadataDriverImpl($driverImpl);

        // Configurar o cache (pode ser desabilitado ou customizado)
        // $redisConnection = RedisAdapter::createConnection('redis://redis:6379');
        // $redisCache = new RedisAdapter($redisConnection);
        // $config->setMetadataCache($redisCache);
        // $config->setQueryCache($redisCache);
        // $config->setResultCache($redisCache);
        
        return $config;
    }
}
