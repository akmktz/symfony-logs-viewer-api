<?php

namespace App\Unit\Tests;

use App\Service\LogFileApacheService;
use PHPUnit\Framework\TestCase;

class LogFileApacheServiceTest extends TestCase
{
    public function testGetLogsList(): void
    {
        $logServiceMock = $this->getMockBuilder(LogFileApacheService::class)
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

        $this->assertInstanceOf(LogFileApacheService::class, $logServiceMock);

        $this->assertEquals(
            $logServiceMock->getLogsList(),
            [
                'first_test_file.log',
                'third_test_file.log',
            ]
        );
    }
}
