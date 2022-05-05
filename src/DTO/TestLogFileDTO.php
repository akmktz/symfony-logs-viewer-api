<?php

namespace App\DTO;

use Carbon\Carbon;

class TestLogFileDTO implements LogDTOInterface
{
    /**
     * @var string
     */
    protected string $payload;

    /**
     * @param string $data
     */
    public function __construct(string $data = '')
    {
        $this->setString($data);
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return rtrim($this->payload);
    }

    /**
     * @param string $data
     */
    public function setString(string $data): void
    {
         $this->payload = $data;
    }

    /**
     * @return Carbon
     */
    public function getDateTime(): Carbon
    {
        $dateTimeString = substr($this->payload, 0 , 19);

        return Carbon::parse($dateTimeString);
    }
}
