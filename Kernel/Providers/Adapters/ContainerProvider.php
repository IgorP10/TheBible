<?php

namespace Kernel\Providers\Adapters;

use Kernel\Container\Container;
use Kernel\Providers\ProviderInterface;

class ContainerProvider implements ProviderInterface
{
    public function register(Container $container): void
    {
        $container->singleton(Container::class, fn() => Container::getInstance());
    }
}
