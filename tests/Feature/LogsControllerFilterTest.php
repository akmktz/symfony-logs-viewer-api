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
}
