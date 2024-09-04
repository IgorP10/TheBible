<?php

namespace Kernel\Container;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

class Container
{
    protected array $instances = [];
    protected array $bindings = [];
    private static ?Container $instance = null;

    public function bind($abstract, $concrete = null, $singleton = false, array $parameters = []): void
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = compact('concrete', 'singleton', 'parameters');
    }

    public function singleton($abstract, $concrete = null, array $parameters = []): void
    {
        $this->bind($abstract, $concrete, true, $parameters);
    }

    public function make($abstract, array $additionalParameters = []): mixed
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        $binding = $this->bindings[$abstract] ?? null;
        $concrete = $binding['concrete'] ?? $abstract;
        $parameters = $binding['parameters'] ?? [];

        $resolvedParameters = array_merge($parameters, $additionalParameters);

        if ($concrete instanceof \Closure) {
            $object = $concrete($this);
        } else {
            $object = $this->resolve($concrete, $resolvedParameters);
        }

        if ($binding['singleton'] ?? false) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    protected function resolve($concrete, array $parameters = []): mixed
    {
        $reflector = new ReflectionClass($concrete);
        if (!$reflector->isInstantiable()) {
            throw new ReflectionException("Class {$concrete} is not instantiable");
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return new $concrete;
        }

        $constructorParameters = $constructor->getParameters();
        $dependencies = $this->resolveDependencies($constructorParameters, $parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    protected function resolveDependencies(array $parameters, array $additionalParameters = []): array
    {
        return array_map(function (ReflectionParameter $parameter) use ($additionalParameters) {
            $name = $parameter->getName();

            if (array_key_exists($name, $additionalParameters)) {
                return $additionalParameters[$name];
            }

            $type = $parameter->getType();
            if (!$type || $type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    return $parameter->getDefaultValue();
                }
                throw new ReflectionException("Cannot resolve the parameter {$name} with no type hint and no default value.");
            }

            return $this->make($type->getName());
        }, $parameters);
    }

    public static function getInstance(): Container
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
