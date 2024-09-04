<?php

namespace Kernel\Http\Request\Interfaces;

interface RequestInterface
{
    public function getMethod(): string;
    public function getUri(): string;
    public function getHeaders(): array;
    public function getBody();
    public function getQueryParams(): array;
    public function getCookies(): array;
    public function all(): array;
}
