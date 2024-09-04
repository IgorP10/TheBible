<?php

namespace Kernel\Http\Middleware;

use Kernel\Http\Request\Interfaces\RequestInterface;
use Kernel\Http\Response\Interfaces\ResponseInterface;

interface MiddlewareInterface
{
    public function handle(RequestInterface $request, \Closure $next): ResponseInterface;
}
