<?php

namespace App\Unit\Tests;

use App\Service\TestLogFile\TestLogFileService;
use PHPUnit\Framework\TestCase;

class TestLogFileServiceMockTest extends TestCase
{
    public function testMockGetLogsList(): void
    {
        $logServiceMock = $this->getMockBuilder(TestLogFileService::class)
            ->setConstructorArgs([
                'path' => '/test_path/'
            ])
            ->onlyMethods([
                'getFilesList',
                'checkIsFile',
            ])
            ->getMock();


        $logServiceMock->expects($this->once())
            ->method('getFilesList')
            ->willReturnCallback(
                fn ($path) => [
                    str_replace('*.log', 'first_test_file.log', $path),
                    str_replace('*.log', 'second_test_directory.log', $path),
                    str_replace('*.log', 'third_test_file.log', $path),
                ]
            );

        $logServiceMock->expects($this->exactly(3))
            ->method('checkIsFile')
            ->willReturnCallback(
                fn ($fileName) => !str_contains($fileName, 'directory')
            );

        $this->assertInstanceOf(TestLogFileService::class, $logServiceMock);

        $this->assertEquals(
            $logServiceMock->getLogsList(),
            [
                'first_test_file.log',
                'third_test_file.log',
            ]
        );
    }

    public function testMockGetLogSize(): void
    {
        $logServiceMock = $this->getMockBuilder(TestLogFileService::class)
            ->setConstructorArgs([
                'path' => '/test_path/'
            ])
            ->onlyMethods([
                'getFileSize',
            ])
            ->getMock();


        $logServiceMock->expects($this->once())
            ->method('getFileSize')
            ->willReturn(12345);

        $this->assertInstanceOf(TestLogFileService::class, $logServiceMock);

        $this->assertEquals(
            $logServiceMock->getLogSize('test.log'),
            12345
        );
    }
}
