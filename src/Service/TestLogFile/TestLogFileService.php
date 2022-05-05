<?php

namespace App\Service\TestLogFile;

use App\Service\LogIteratorInterface;
use App\Service\LogServiceInterface;

class TestLogFileService implements LogServiceInterface
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
     * @param string $logName
     * @return int|null
     */
    public function getLogSize(string $logName): ?int
    {
        return $this->getFileSize($this->path . $logName);
    }

    /**
     * @param string $logName
     * @param int $offset
     * @return LogIteratorInterface
     */
    public function getLogData(string $logName, int $offset = 0): LogIteratorInterface
    {
        $iterator = new TestLogFileIterator($this->path . $logName);
        if ($offset) {
            $iterator->fseek($offset);
        }

        return $iterator;
    }


    // File operations
    /**
     * @param string $path
     * @return array
     */
    protected function getFilesList(string $path): array
    {
        return glob($path);
    }

    /**
     * @param string $fileName
     * @return bool
     */
    protected function checkIsFile(string $fileName): bool
    {
        return !is_dir($fileName);
    }

    /**
     * @param string $fileName
     * @return int|null
     */
    protected function getFileSize(string $fileName): ?int
    {
        return filesize($fileName);
    }
}
