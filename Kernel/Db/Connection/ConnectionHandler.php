<?php

namespace Kernel\Db\Connection;

class ConnectionHandler
{
    public function __construct(private string $connectionName)
    {
    }

    public function getConnection(): Connection
    {
        return $this->createConnection();
    }

    private function createConnection(): Connection
    {
        $config = $this->getConfiguration();

        return new Connection(
            $config['driver'] ?? null,
            $config['host'] ?? null,
            $config['port'] ?? null,
            $config['username'] ?? null,
            $config['password'] ?? null,
            $config['database'] ?? null,
            $config['charset'] ?? null
        );
    }

    private function connectionName(): string
    {
        return $this->connectionName;
    }

    private function getConfiguration(): ?array
    {
        return config("database.connection." . $this->connectionName());
    }
}
