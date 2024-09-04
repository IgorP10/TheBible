<?php

namespace Kernel\Cache;

use Kernel\Cache\Adapters\File;
use Kernel\Cache\Adapters\Redis;
use Kernel\Cache\CacheInterface;

class CacheDriver
{
    private ?string $value;

    public function __construct()
    {
        $this->value = env('CACHE_DRIVER', 'file');
    }

    protected static function enums(): array
    {
        return [
            "file" => File::class,
            "redis" => Redis::class
        ];
    }

    public function adapter(): CacheInterface
    {
        return resolve(self::enums()[$this->value]);
    }
}
