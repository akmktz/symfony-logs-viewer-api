<?php

namespace App\Feature\Tests;

use App\Service\TestLogFile\TestLogFileService;
use App\Tests\Feature\BaseTestCase;

class LogsControllerPaginationTest extends BaseTestCase
{
    protected TestLogFileService $logService;

    public function testShowPaginationPage1(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'per_page' => 2,
        ]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            'data' => [
                [
                    'date_time' => '2022-04-25T19:05:28.000000Z',
                    'data' => '2022-04-25 19:05:28 "GET https://test.com/test3.html HTTP/1.1"',
                ],
                [
                    'date_time' => '2022-04-25T19:05:27.000000Z',
                    'data' => '2022-04-25 19:05:27 "GET https://test.com/test2.html HTTP/1.1"',
                ],
            ],
            'paginator' => [
                'page' => 1,
                'per_page' => 2,
                'total_items' => 3,
                'total_pages' => 2,
            ],
        ]);
    }

    public function testShowPaginationPage2(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'page' => 2,
            'per_page' => 2,
        ]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            'data' => [
                [
                    'date_time' => '2022-04-25T19:05:26.000000Z',
                    'data' => '2022-04-25 19:05:26 "GET https://test.com/test1.html HTTP/1.1"',
                ],
            ],
            'paginator' => [
                'page' => 2,
                'per_page' => 2,
                'total_items' => 3,
                'total_pages' => 2,
            ],
        ]);
    }

    public function testShowOrderAsc(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'per_page' => 2,
            'sort' => 'id',
            'order' => 'asc',
        ]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            'data' => [
                [
                    'date_time' => '2022-04-25T19:05:26.000000Z',
                    'data' => '2022-04-25 19:05:26 "GET https://test.com/test1.html HTTP/1.1"',
                ],
                [
                    'date_time' => '2022-04-25T19:05:27.000000Z',
                    'data' => '2022-04-25 19:05:27 "GET https://test.com/test2.html HTTP/1.1"',
                ],
            ],
            'paginator' => [
                'page' => 1,
                'per_page' => 2,
                'total_items' => 2,
                'total_pages' => 3,
            ],
        ]);
    }

    public function testShowOrderDesc(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'per_page' => 2,
            'sort' => 'id',
            'order' => 'desc',
        ]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            'data' => [
                [
                    'date_time' => '2022-04-25T19:05:27.000000Z',
                    'data' => '2022-04-25 19:05:27 "GET https://test.com/test2.html HTTP/1.1"',
                ],
                [
                    'date_time' => '2022-04-25T19:05:28.000000Z',
                    'data' => '2022-04-25 19:05:28 "GET https://test.com/test3.html HTTP/1.1"',
                ],
            ],
            'paginator' => [
                'page' => 1,
                'per_page' => 2,
                'total_items' => 2,
                'total_pages' => 3,
            ],
        ]);
    }
}
