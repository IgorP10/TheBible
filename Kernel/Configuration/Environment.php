<?php

declare(strict_types=1);

namespace Kernel\Configuration;

/**
 * This class is responsible for managing environment settings
 */
class Environment
{
    private static array $ENVIRONMENTS_VARIABLES = [];
    private static array $ENVIRONMENTS_VARIABLES_FROM_FILE = [];
    private static array $ENVIRONMENTS_ALL = [];

    /**
     * @return array<string, mixed>
     */
    public function getEnvironments(): array
    {
        if (empty(self::$ENVIRONMENTS_ALL)) {
            self::$ENVIRONMENTS_ALL = array_merge(
                $this->createEnvironments(),
                $this->createEnvironmentsFromFile()
            );
        }

        return self::$ENVIRONMENTS_ALL;
    }

    private function createEnvironments(): array
    {
        if (empty(self::$ENVIRONMENTS_VARIABLES)) {
            self::$ENVIRONMENTS_VARIABLES = (array) getenv();
        }

        return self::$ENVIRONMENTS_VARIABLES;
    }

    private function createEnvironmentsFromFile(): array
    {
        if (empty(self::$ENVIRONMENTS_VARIABLES_FROM_FILE)) {
            $filePath = __DIR__ . '/../../.env';
            if (file_exists($filePath)) {
                try {
                    self::$ENVIRONMENTS_VARIABLES_FROM_FILE = parse_ini_file($filePath, true, INI_SCANNER_TYPED);
                } catch (\Throwable $e) {
                    self::$ENVIRONMENTS_VARIABLES_FROM_FILE = [];
                }
            }
        }

        return self::$ENVIRONMENTS_VARIABLES_FROM_FILE;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function set(string $key, mixed $value): self
    {
        $this->createEnvironmentsFromFile();
        self::$ENVIRONMENTS_VARIABLES_FROM_FILE[$key] = $value;
        self::$ENVIRONMENTS_ALL = [];

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
