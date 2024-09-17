<?php

namespace Kernel;

use Kernel\Routes\Router;
use Kernel\Http\Dispatcher;
use Kernel\Http\Response\Response;
use Kernel\Routes\ControllersRegistry;
use Kernel\Providers\ProviderInterface;
use Kernel\Providers\ProvidersRegistry;

class Kernel
{
    public function __construct()
    {
        $this->registerServices();
    }

    public function run(): void
    {
        try {
            if (!defined("ROOT_PATH")) {
                define("ROOT_PATH", __DIR__ . "/..");
            }
            $this->initializeRoutes();
        } catch (\Throwable $exception) {
            $errorResponse = Response::json(
                [
                    'error' => $exception->getCode(),
                    'message' => $exception->getMessage()
                ],
                500
            );

            $errorResponse->send();
        }
    }

    private function registerServices(): void
    {
        $container = container();
        /** @var ProviderInterface $provider */
        foreach (ProvidersRegistry::getProviders() as $provider) {
            $container->make($provider)->register($container);
        }
    }

    private function initializeRoutes(): void
    {
        /** @var Router $router */
        $router = container()->make(Router::class);
        /** @var ControllersRegistry $controllerRegistry */
        $controllerRegistry = container()->make(ControllersRegistry::class);
        foreach ($controllerRegistry->getControllers() as $controller) {
            $router->register($controller);
        }

        /** @var Dispatcher $dispatcher */
        $dispatcher = container()->make(Dispatcher::class);
        $dispatcher->dispatch();
    }
}
