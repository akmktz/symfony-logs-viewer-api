<?php

namespace App\Feature\Tests;

use App\Tests\Feature\BaseTestCase;

class LogsControllerFilterTest extends BaseTestCase
{
    protected LogsControllerFilterTest $logService;

    public function testShowFilterLike(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'search' => 'test2',
        ]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            'data' => [
                [
                    'date_time' => '2022-04-25T19:05:27.000000Z',
                    'data' => '2022-04-25 19:05:27 "GET https://test.com/test2.html HTTP/1.1"',
                ],
            ],
            'paginator' => [
                'page' => 1,
                'per_page' => 10,
                'total_items' => 1,
                'total_pages' => 1,
            ],
        ]);
    }

    public function testShowFilterMatch(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'search' => 'GET https://\w+\.\w+/\w+[13]\.\w{4}',
            'search_type' => 'regex',
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
                    'date_time' => '2022-04-25T19:05:28.000000Z',
                    'data' => '2022-04-25 19:05:28 "GET https://test.com/test3.html HTTP/1.1"',
                ],
            ],
            'paginator' => [
                'page' => 1,
                'per_page' => 10,
                'total_items' => 2,
                'total_pages' => 1,
            ],
        ]);
    }

    public function testShowFilterPeriod(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'from' => '2022-04-25T19:05:27',
            'to' => '2022-04-25T19:05:27',
        ]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            'data' => [
                [
                    'date_time' => '2022-04-25T19:05:27.000000Z',
                    'data' => '2022-04-25 19:05:27 "GET https://test.com/test2.html HTTP/1.1"',
                ],
            ],
            'paginator' => [
                'page' => 1,
                'per_page' => 10,
                'total_items' => 1,
                'total_pages' => 1,
            ],
        ]);
    }
}
