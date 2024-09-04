<?php

namespace Kernel\Cache\Adapters;

use Kernel\Cache\CacheInterface;

class File implements CacheInterface
{
    private string $storagePath;

    public function __construct(string $storagePath)
    {
        $this->storagePath = rtrim($storagePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0777, true);
        }
    }

    public function get(string $key): mixed
    {
        $filePath = $this->getFilePath($key);

        if (!file_exists($filePath)) {
            return null;
        }

        $data = $this->readFile($filePath);
        if ($this->isExpired($data['expires_at'])) {
            unlink($filePath);
            return null;
        }

        return unserialize($data['value']);
    }

    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        $filePath = $this->getFilePath($key);
        $data = [
            'value' => serialize($value),
            'expires_at' => time() + $ttl
        ];

        return $this->writeFile($filePath, serialize($data));
    }

    public function has(string $key): bool
    {
        $filePath = $this->getFilePath($key);

        if (!file_exists($filePath)) {
            return false;
        }

        $data = $this->readFile($filePath);
        return !$this->isExpired($data['expires_at']);
    }

    public function delete(string $key): bool
    {
        $filePath = $this->getFilePath($key);

        return file_exists($filePath) && unlink($filePath);
    }

    public function clear(): bool
    {
        $files = glob($this->storagePath . '*.cache');
        foreach ($files as $file) {
            unlink($file);
        }
        return true;
    }

    private function getFilePath(string $key): string
    {
        // Organizar em subdiretórios com base no hash pode melhorar o desempenho em pastas com muitos arquivos.
        $hash = md5($key);
        $subDir = substr($hash, 0, 2) . DIRECTORY_SEPARATOR;
        $dirPath = $this->storagePath . $subDir;

        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        return $dirPath . $hash . '.cache';
    }

    private function isExpired(int $expiresAt): bool
    {
        return time() > $expiresAt;
    }

    private function readFile(string $filePath): array
    {
        $content = file_get_contents($filePath);
        return unserialize($content);
    }

    private function writeFile(string $filePath, string $data): bool
    {
        try {
            return file_put_contents($filePath, $data) !== false;
        } catch (\Exception $e) {
            // Log do erro pode ser adicionado aqui.
            return false;
        }
    }
}
