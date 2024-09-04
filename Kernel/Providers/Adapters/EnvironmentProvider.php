<?php

namespace Kernel\Providers\Adapters;

use Kernel\Container\Container;
use Kernel\Configuration\Environment;
use Kernel\Providers\ProviderInterface;

class EnvironmentProvider implements ProviderInterface
{
    public function register(Container $container): void
    {
        $container->singleton(Environment::class, fn() => new Environment());
    }
}
