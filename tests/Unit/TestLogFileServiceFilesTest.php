<?php

namespace App\Unit\Tests;

use App\DTO\TestLogFileDTO;
use App\Service\TestLogFile\TestLogFileIterator;
use App\Service\TestLogFile\TestLogFileService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TestLogFileServiceFilesTest extends KernelTestCase
{
    protected TestLogFileService $logService;

    protected function setUp(): void
    {
        parent::setUp();

        $logFilesPath = static::getContainer()->getParameter('logs.path');
        $this->logService = new TestLogFileService($logFilesPath);
    }

    public function testGetLogsList(): void
    {
        $this->assertEquals(
            $this->logService->getLogsList(),
            [
                'first_test_file.log',
                'second_test_file.log',
            ]
        );
    }

    public function testGetLogSize(): void
    {
        $this->assertEquals(
            $this->logService->getLogSize('first_test_file.log'),
            188
        );

        $this->assertEquals(
            $this->logService->getLogSize('second_test_file.log'),
            61
        );
    }

    public function testGetLogData(): void
    {
        $iterator = $this->logService->getLogData('first_test_file.log');
        $this->assertTrue($iterator instanceof TestLogFileIterator);

        $this->assertTrue($iterator->current() instanceof TestLogFileDTO);

        $this->assertEquals(
            $iterator->getSize(),
            188
        );

        $this->assertEquals(
            $iterator->current()->getString(),
            '2022-04-25 19:05:26 "GET https://test.com/test1.html HTTP/1.1"'
        );


        $this->assertEquals(
            $iterator->current()->getDateTime(),
            '2022-04-25 19:05:26'
        );

        $iterator->goto(126);
        $iterator->next();

        $this->assertEquals(
            $iterator->current()->getString(),
            '2022-04-25 19:05:28 "GET https://test.com/test3.html HTTP/1.1"'
        );
    }
}
