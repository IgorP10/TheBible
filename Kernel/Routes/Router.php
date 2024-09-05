<?php

namespace Kernel\Routes;

use Kernel\Http\Middleware\MiddlewareAttribute;
use Kernel\Http\Request\Interfaces\RequestInterface;
use Kernel\Http\Response\Interfaces\ResponseInterface;

class Router
{
    protected static $routes = [];

    public function register($controllerClass)
    {
        $reflectionClass = new \ReflectionClass($controllerClass);
        foreach ($reflectionClass->getMethods() as $method) {
            $middlewares = [];
            foreach ($method->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();
                if ($instance instanceof RouteAttribute) {
                    $routeInfo = $instance;
                } elseif ($instance instanceof MiddlewareAttribute) {
                    $middlewares = $instance->middlewares;
                }
            }

            if (isset($routeInfo)) {
                self::$routes[$routeInfo->method][$routeInfo->path] = [
                    'controller' => $controllerClass,
                    'method' => $method->name,
                    'middlewares' => $middlewares,
                    'requiredParams' => $routeInfo->requiredParams
                ];
            }
        }
    }

    public function route(RequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri();
        $method = $request->getMethod();
        $action = self::$routes[$method][$uri] ?? null;

        if (!$action) {
            throw new \Exception("Route not found", 404);
        }

        // Valida parâmetros obrigatórios se houver
        foreach ($action['requiredParams'] as $param) {
            if (!$request->getAttribute($param)) {
                throw new \Exception("Missing required parameter: $param", 400);
            }
        }

        // Lida com middlewares
        foreach ($action['middlewares'] as $middleware) {
            $middlewareInstance = resolve($middleware);
            $response = $middlewareInstance->handle($request, function ($request) use ($action) {
                $controllerInstance = resolve($action['controller']);
                return $controllerInstance->{$action['method']}($request);
            });

            if ($response instanceof ResponseInterface) {
                return $response;
            }
        }

        $controllerInstance = resolve($action['controller']);
        return $controllerInstance->{$action['method']}($request);
    }
}
