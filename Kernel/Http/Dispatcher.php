<?php

namespace Kernel\Http;

use Kernel\Routes\Router;
use Kernel\Http\Request\Request;
use Kernel\Http\Response\Interfaces\ResponseInterface;

class Dispatcher
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function dispatch()
    {
        $request = new Request();
        $response = $this->router->route($request);
        $response = $this->prepareResponse($response);
        $response->send();
    }

    private function prepareResponse(ResponseInterface $response): false|ResponseInterface
    {
        $response->addHeader("Access-Control-Allow-Origin", "*");
        $response->addHeader("Access-Control-Allow-Headers", "*");
        $response->addHeader("Access-Control-Allow-Methods", "POST, GET, OPTIONS, PUT, DELETE");

        return $response;
    }
}
