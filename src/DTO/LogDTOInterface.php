<?php

namespace App\DTO;

use Carbon\Carbon;

interface LogDTOInterface
{
    /**
     * @param string $data
     */
    public function __construct(string $data);

    /**
     * @return string
     */
    public function getString(): string;

    /**
     * @param string $data
     */
    public function setString(string $data): void;

    /**
     * @return Carbon
     */
    public function getDateTime(): Carbon;
}
