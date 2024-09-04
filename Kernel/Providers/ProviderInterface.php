<?php

namespace Kernel\Providers;

use Kernel\Container\Container;

interface ProviderInterface
{
    public function register(Container $container): void;
}
