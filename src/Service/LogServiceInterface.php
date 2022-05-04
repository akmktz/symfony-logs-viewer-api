<?php

namespace App\Service;

interface LogServiceInterface
{
    /**
     * @return string[]
     */
    public function getLogsList(): array;
}
