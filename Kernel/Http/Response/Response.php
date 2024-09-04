<?php

namespace Kernel\Http\Response;

use Kernel\Http\Response\Handlers\JsonResponse;
use Kernel\Http\Response\Interfaces\ResponseInterface;

class Response
{
    public static function json(array $body, int $statusCode = 200, array $headers = []): ResponseInterface
    {
        return new JsonResponse($body, $statusCode, $headers);
    }
}
