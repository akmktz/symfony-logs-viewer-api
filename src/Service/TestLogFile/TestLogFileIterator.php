<?php

namespace App\Service\TestLogFile;

use App\DTO\LogDTOInterface;
use App\DTO\TestLogFileDTO;
use App\Service\LogIteratorInterface;

class TestLogFileIterator extends \SplFileObject implements LogIteratorInterface
{
    /**
     * @return LogDTOInterface
     */
    public function current(): LogDTOInterface
    {
        $data = parent::current();

        return new TestLogFileDTO($data);
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return parent::getSize();
    }

    /**
     * @param int $offset
     */
    public function goto(int $offset): void
    {
        $this->fseek($offset);
    }
}
