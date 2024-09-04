<?php

namespace Kernel\Providers\Adapters;

use Kernel\Routes\Router;
use Kernel\Http\Dispatcher;
use Kernel\Container\Container;
use Kernel\Providers\ProviderInterface;

class RouteProvider implements ProviderInterface
{
    public function register(Container $container): void
    {
        $container->singleton(Router::class, fn() => new Router());
        $container->singleton(Dispatcher::class, fn() => new Dispatcher(resolve(Router::class)));
    }
}
