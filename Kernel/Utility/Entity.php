<?php

namespace Kernel\Utility;

use ReflectionClass;

abstract class Entity implements \JsonSerializable
{
    public function __call(string $method, mixed $args)
    {
        $property = lcfirst(substr($method, 3));

        if (str_starts_with($method, 'get')) {
            return $this->getProperty($property);
        }

        if (str_starts_with($method, 'set')) {
            $this->setProperty($property, $args);
        }
    }

    private function getProperty(string $property): mixed
    {
        $property = $this->getInstance()->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($this);
    }

    private function setProperty(string $property, mixed $value): void
    {
        $property = $this->getInstance()->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($this, ...$value);
    }

    public function jsonSerialize(): array
    {
        $properties = $this->getInstance()->getProperties();
        $data = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $data[$property->getName()] = $property->getValue($this);
        }

        return $data;
    }

    private function getInstance(): ReflectionClass
    {
        return new ReflectionClass($this);
    }
}
