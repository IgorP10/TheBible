<?php

namespace Kernel\Routes;

class ControllersRegistry
{
    protected array $controllers = [];

    public function __construct()
    {
        $this->searchControllers();
    }

    protected function searchControllers()
    {
        $path = ROOT_PATH . '/App';
        $this->scanDirectory($path);
    }

    protected function scanDirectory(string $directory)
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $this->registerController($file->getPathname());
            }
        }
    }

    protected function registerController(string $filePath)
    {
        if (strpos($filePath, '/Http/Controller/') !== false) {
            $className = $this->convertPathToClassName($filePath);
            $this->controllers[] = $className;
        }
    }

    protected function convertPathToClassName(string $filePath): string
    {
        $relativePath = str_replace(ROOT_PATH . '/App/', '', $filePath);
        $relativePath = str_replace('.php', '', $relativePath);
        
        return 'App\\' . str_replace('/', '\\', $relativePath);
    }

    public function getControllers(): array
    {
        return $this->controllers;
    }
}
