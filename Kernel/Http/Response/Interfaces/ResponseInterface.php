<?php

namespace Kernel\Http\Response\Interfaces;

interface ResponseInterface
{
    public function getStatusCode(): int;
    public function getHeaders(): array;
    public function getContent(): string;
    public function addHeader(string $name, string $value): void;
    public function setStatusCode(int $statusCode): void;
    public function setContent(string $content): void;
    public function send(): void;
}
