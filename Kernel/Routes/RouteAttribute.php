<?php

namespace Kernel\Routes;

#[\Attribute]
class RouteAttribute
{
    public function __construct(
        public string $method,
        public string $path,
        public array $requiredParams = [],
        public string $prefix = '/api'
    ) {
        if (!str_starts_with($this->path, $prefix)) {
            $this->path = rtrim($prefix, '/') . '/' . ltrim($this->path, '/');
        }
    }
}
