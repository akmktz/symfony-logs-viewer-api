<?php

namespace App\Feature\Tests;

use App\Service\TestLogFileService;
use App\Tests\Feature\BaseTestCase;

class LogsControllerTest extends BaseTestCase
{
    public function testList(): void
    {
        $data = [
            'first_test_file.log',
            'second_test_directory.log',
            'third_test_file.log',
        ];

        $client = static::createClient();

        $logServiceMock = $this->createPartialMock(TestLogFileService::class, ['getLogsList']);
        $logServiceMock->expects($this->once())
            ->method('getLogsList')
            ->willReturn($data);

        static::getContainer()->set(TestLogFileService::class, $logServiceMock);

        $url = $this->generateUrl('logs_list');
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals($data);
    }
}
