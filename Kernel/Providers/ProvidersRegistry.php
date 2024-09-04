<?php

namespace Kernel\Providers;

use Kernel\Providers\Adapters\CacheProvider;
use Kernel\Providers\Adapters\RouteProvider;
use Kernel\Providers\Adapters\ContainerProvider;
use Kernel\Providers\Adapters\EnvironmentProvider;

class ProvidersRegistry
{
    protected static $providers = [
        ContainerProvider::class,
        CacheProvider::class,
        RouteProvider::class,
        EnvironmentProvider::class,
    ];

    public static function getProviders(): array
    {
        return self::$providers;
    }
}
