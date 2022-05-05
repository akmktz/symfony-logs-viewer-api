<?php

namespace App\Service;

interface LogCacheInterface
{
    public function checkAndUpdate(string $logName, LogIteratorInterface $iterator): void;
}
