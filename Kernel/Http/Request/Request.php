<?php

namespace Kernel\Http\Request;

use Kernel\Http\Request\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private array $headers;
    private string $uri;
    private string $method;
    private ?array $queryParams = null;
    private ?array $body = null;

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->headers = getallheaders();
        $this->queryParams = $_GET;
        $this->body = json_decode(file_get_contents('php://input'), true);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return preg_replace('#^/Public/#', '/', $this->uri);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getCookies(): array
    {
        return $_COOKIE;
    }

    public function all(): array
    {
        return [
            'method' => $this->getMethod(),
            'uri' => $this->getUri(),
            'headers' => $this->getHeaders(),
            'body' => $this->getBody(),
            'queryParams' => $this->getQueryParams(),
            'cookie' => $this->getCookies()
        ];
    }
}
