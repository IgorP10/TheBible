<?php

namespace Kernel\Providers\Adapters;

use Kernel\Cache\CacheInterface;
use Kernel\Container\Container;
use Kernel\Cache\CacheDriver;
use Kernel\Providers\ProviderInterface;

class CacheProvider implements ProviderInterface
{
    public function register(Container $container): void
    {
        $container->singleton(CacheInterface::class, fn() => (new CacheDriver())->adapter());
    }
}
