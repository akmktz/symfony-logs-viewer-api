<?php

namespace App\Service;

interface LogServiceInterface
{
    /**
     * @return string[]
     */
    public function getLogsList(): array;

    /**
     * @param string $logName
     * @return int|null
     */
    public function getLogSize(string $logName): ?int;

    /**
     * @param string $logName
     * @param int $offset
     * @return LogIteratorInterface
     */
    public function getLogData(string $logName, int $offset = 0): LogIteratorInterface;
}
