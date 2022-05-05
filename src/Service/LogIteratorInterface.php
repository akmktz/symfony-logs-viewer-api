<?php

namespace App\Service;

use App\DTO\LogDTOInterface;

interface LogIteratorInterface extends \Iterator
{
    /**
     * @return LogDTOInterface
     */
    public function current(): LogDTOInterface;

    /**
     * @return int|null
     */
    public function getSize(): ?int;

    /**
     * @param int $offset
     */
    public function goto(int $offset): void;
}
