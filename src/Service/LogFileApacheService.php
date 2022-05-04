<?php

namespace App\Service;

class LogFileApacheService implements LogServiceInterface
{
    /**
     * @var string
     */
    protected string $path = '';

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path ? (rtrim($path, '/') . '/') : '';
    }

    /**
     * @return string[]
     */
    public function getLogsList(): array
    {
        $logsList = $this->getFilesList($this->path . '*.log');

        // Remove directories from list
        $logsList = array_filter(
            $logsList,
            fn ($fileName) => $this->checkIsFile($fileName)
        );

        // Remove path from file name
        $logsList = array_map(
            fn ($fileName) => str_replace($this->path, '', $fileName),
            $logsList
        );

        return array_values($logsList);
    }

    /**
     * @return array
     */
    protected function getFilesList($path): array
    {
        return glob($path);
    }

    /**
     * @return bool
     */
    protected function checkIsFile($fileName): bool
    {
        return !is_dir($fileName);
    }
}
