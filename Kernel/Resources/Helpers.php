<?php

use Kernel\Container\Container;
use Kernel\Cache\CacheInterface;
use Kernel\Configuration\Environment;

if (!function_exists('dd')) {
    function dd(...$data): void
    {
        foreach ($data as $item) {
            echo "<pre>";
            var_dump($item);
            echo "</pre>";
        }
        die();
    }
}

if (!function_exists('container')) {
    function container(): Container
    {
        return Container::getInstance();
    }
}

if (!function_exists('resolve')) {
    function resolve($abstract): mixed
    {
        return container()->make($abstract);
    }
}

if (!function_exists('env')) {
    function env(string $key, ?string $default = null): mixed
    {
        $environment = resolve(Environment::class);

        return $environment->get($key, $default);
    }
}

if (!function_exists('setEnv')) {
    function setEnv(string $key, mixed $value): mixed
    {
        $environment = resolve(Environment::class);

        return $environment->set($key, $value);
    }
}

if (!function_exists('cache')) {
    function cache(): CacheInterface
    {
        return resolve(CacheInterface::class);
    }
}

if (!function_exists('setCache')) {
    function setCache(string $key, mixed $value, int $ttl = 3600): bool
    {
        return cache()->set($key, $value, $ttl);
    }
}

if (!function_exists('config')) {
    function config(string $key): ?array
    {
        static $config = [];

        $keys = explode('.', $key);
        $file = array_shift($keys);

        if (!isset($config[$file])) {
            $filePath = sprintf('%s/config/%s.php', ROOT_PATH, $file);
            if (file_exists($filePath)) {
                $config[$file] = require_once $filePath;
            }
        }

        $value = $config[$file] ?? null;

        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                return null;
            }

            $value = $value[$key];
        }

        return $value;
    }
}
