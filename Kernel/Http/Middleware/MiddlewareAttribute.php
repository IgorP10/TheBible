<?php

namespace Kernel\Http\Middleware;

#[\Attribute]
class MiddlewareAttribute
{
    public function __construct(public array $middlewares)
    {
    }
}
