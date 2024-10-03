<?php

declare(strict_types=1);

namespace Kernel\Configuration;

/**
 * This class is responsible for managing environment settings
 */
class Environment
{
    private static array $environmentsVariables = [];
    private static array $environmentsVariablesFromFile = [];
    private static array $environmentsAll = [];

    /**
     * @return array<string, mixed>
     */
    public function getEnvironments(): array
    {
        if (empty(self::$environmentsAll)) {
            self::$environmentsAll = array_merge(
                $this->createEnvironments(),
                $this->createEnvironmentsFromFile()
            );
        }

        return self::$environmentsAll;
    }

    private function createEnvironments(): array
    {
        if (empty(self::$environmentsVariables)) {
            self::$environmentsVariables = (array) getenv();
        }

        return self::$environmentsVariables;
    }

    private function createEnvironmentsFromFile(): array
    {
        if (empty(self::$environmentsVariablesFromFile)) {
            $filePath = __DIR__ . '/../../.env';
            if (file_exists($filePath)) {
                try {
                    self::$environmentsVariablesFromFile = parse_ini_file($filePath, true, INI_SCANNER_TYPED);
                } catch (\Throwable $e) {
                    self::$environmentsVariablesFromFile = [];
                }
            }
        }

        return self::$environmentsVariablesFromFile;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function set(string $key, mixed $value): self
    {
        $this->createEnvironmentsFromFile();
        self::$environmentsVariablesFromFile[$key] = $value;
        self::$environmentsAll = [];

        return $this;
    }

    /**
     * @param string $key
     * @param string|null $defaultValue
     * @return mixed
     */
    public function get(string $key, ?string $defaultValue = null): mixed
    {
        $environments = $this->getEnvironments();
        return $environments[$key] ?? $defaultValue;
    }
}
