<?php

declare(strict_types=1);

namespace Kernel\Configuration;

use RuntimeException;

/**
 * Singleton class responsible for managing environment settings
 */
class Environment
{
    private static ?self $instance = null;
    private array $envVariables = [];
    private array $envVariablesFromFile = [];

    public function __construct()
    {
        $this->envVariables = $this->loadSystemEnvironments();
        $this->envVariablesFromFile = $this->loadEnvironmentsFromFile();
    }

    /**
     * @return array<string, mixed>
     */
    public function getEnvironments(): array
    {
        return array_merge($this->envVariables, $this->envVariablesFromFile);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->envVariablesFromFile[$key] = $value;
    }

    /**
     * @param string $key
     * @param string|null $defaultValue
     * @return mixed
     */
    public function get(string $key, ?string $defaultValue = null): mixed
    {
        $env = $this->getEnvironments();
        return $env[$key] ?? $defaultValue;
    }

    /**
     * Load system environment variables
     * 
     * @return array<string, mixed>
     */
    private function loadSystemEnvironments(): array
    {
        return (array) getenv();
    }

    /**
     * Load environment variables from .env file
     * 
     * @return array<string, mixed>
     */
    private function loadEnvironmentsFromFile(): array
    {
        $filePath = __DIR__ . '/../../.env';
        if (!file_exists($filePath)) {
            return [];
        }

        $envVariables = parse_ini_file($filePath, true, INI_SCANNER_TYPED);
        if ($envVariables === false) {
            throw new RuntimeException("Failed to parse .env file at: {$filePath}");
        }

        return $envVariables;
    }
}
