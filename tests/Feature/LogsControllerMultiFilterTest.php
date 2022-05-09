<?php

namespace App\Feature\Tests;

use App\Tests\Feature\BaseTestCase;

class LogsControllerMultiFilterTest extends BaseTestCase
{
    protected LogsControllerFilterTest $logService;

    public function testShowMultiFilterLikeAndMatch(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'search' => [
                'test1',
                'GET https://\w+\.\w+/\w+[03]\.\w{4}',
                ],
            'search_type' => [
                'string',
                'regex',
            ],
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

    public function testShowMultiFilterPeriod(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'from' => [
                '2022-04-25T19:05:26',
                '2022-04-25T19:05:28',
            ],
            'to' => [
                '2022-04-25T19:05:26',
                '2022-04-25T19:05:28',
            ],
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

    public function testShowMultiFilterAll1(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'from' => [
                '2022-04-25T19:05:26',
                '2022-04-25T19:05:28',
            ],
            'to' => [
                '2022-04-25T19:05:26',
                '2022-04-25T19:05:28',
            ],
            'search' => [
                'test1',
                'GET https://\w+\.\w+/\w+[03]\.\w{4}',
            ],
            'search_type' => [
                'string',
                'regex',
            ],
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

    public function testShowMultiFilterAll2(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'from' => [
                '2022-04-25T19:05:28',
                '2022-04-25T19:05:28',
            ],
            'to' => [
                '2022-04-25T19:05:26',
                '2022-04-25T19:05:28',
            ],
            'search' => [
                'test1',
                'GET https://\w+\.\w+/\w+[03]\.\w{4}',
            ],
            'search_type' => [
                'string',
                'regex',
            ],
        ]);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            'data' => [
                [
                    'date_time' => '2022-04-25T19:05:28.000000Z',
                    'data' => '2022-04-25 19:05:28 "GET https://test.com/test3.html HTTP/1.1"',
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

    public function testShowMultiFilterAll3(): void
    {
        $client = static::createClient();

        $url = $this->generateUrl('logs_show', [
            'logName' => 'first_test_file.log',
            'from' => [
                '2022-04-25T19:05:26',
                '2022-04-25T19:05:28',
            ],
            'to' => [
                '2022-04-25T19:05:26',
                '2022-04-25T19:05:28',
            ],
            'search' => [
                'test1',
                'GET https://\w+\.\w+/\w+[09]\.\w{4}',
            ],
            'search_type' => [
                'string',
                'regex',
            ],
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
                'page' => 1,
                'per_page' => 10,
                'total_items' => 1,
                'total_pages' => 1,
            ],
        ]);
    }
}
