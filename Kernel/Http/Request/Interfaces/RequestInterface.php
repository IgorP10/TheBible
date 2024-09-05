<?php

namespace Kernel\Http\Request\Interfaces;

interface RequestInterface
{
    public function getMethod(): string;
    public function getUri(): string;
    public function getHeaders(): array;
    public function getBody();
    public function getQueryParams(): array;
    public function getAttribute(string $key): mixed;
    public function setAttributes(array $attributes): void;
    public function getCookies(): array;
    public function all(): array;
}
