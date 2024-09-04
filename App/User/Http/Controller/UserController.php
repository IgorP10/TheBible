<?php

namespace App\User\Http\Controller;

use Kernel\Routes\RouteAttribute;
use Kernel\Http\Response\Response;
use Kernel\Http\Request\Interfaces\RequestInterface;
use Kernel\Http\Response\Interfaces\ResponseInterface;

class UserController
{
    #[RouteAttribute('GET', '/user')]
    public function index(RequestInterface $request): ResponseInterface
    {
        $users = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => '',
            ],
            [
                'id' => 2,
                'name' => 'Jane Doe',
                'email' => '',
            ],
        ];
        return Response::json(['data' => $users]);
    }
}
