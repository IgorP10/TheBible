<?php

namespace Kernel\Routes;

#[\Attribute]
class RouteAttribute
{
    public function __construct(public string $method, public string $path)
    {
    }
}