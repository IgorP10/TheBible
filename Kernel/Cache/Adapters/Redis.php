<?php

namespace Kernel\Cache\Adapters;

use Predis\Client;
use Predis\ClientInterface;
use Kernel\Cache\CacheInterface;

class Redis implements CacheInterface
{
    private string $host;
    private int $port;
    private string $tcp;
    private ClientInterface $client;

    public function __construct()
    {
        $this->host = env('REDIS_HOST');
        $this->port = env('REDIS_PORT');
        $this->tcp = env('REDIS_SCHEME');
        
        $this->connect();
    }

    private function connect(): void
    {
        $this->client = new Client([
            'scheme' => $this->tcp,
            'host' => $this->host,
            'port' => $this->port
        ]);
    }

    public function get(string $key): mixed
    {
        $data = $this->client->get($key);

        return !is_null($data) ? unserialize($data) : null;
    }

    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        $response = $this->client->set($key, serialize($value), 'EX', $ttl);

        return $response instanceof Status && $response->getPayload() === 'OK';
    }

    public function has(string $key): bool
    {
        return $this->client->exists($key);
    }

    public function ttl(string $key): int
    {
        return $this->client->ttl($key);
    }

    public function delete(string $key): bool
    {
        return $this->client->del($key);
    }

    public function clear(): bool
    {
        return $this->client->flushdb();
    }

    public function __destruct()
    {
        $this->client->disconnect();
    }
}
