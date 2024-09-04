<?php

namespace Kernel\Db\Connection;

class Connection
{
    public function __construct(
        private ?string $driver,
        private ?string $host,
        private ?string $port,
        private ?string $username,
        private ?string $password,
        private ?string $database,
        private ?string $charset
    ) {
    }

    public function getDriver(): ?string
    {
        return $this->driver;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function getPort(): ?string
    {
        return $this->port;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getDatabase(): ?string
    {
        return $this->database;
    }

    public function getCharset(): ?string
    {
        return $this->charset;
    }
}
