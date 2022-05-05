<?php

namespace App\Service;

use Carbon\Carbon;
use Faker\Factory as FakerFactory;

class TestLogFileGenerateService
{
    /**
     * @var string|null
     */
    protected string $logsPath;

    protected $faker;

    /**
     * @param string|null $path
     */
    public function __construct(string $path = null)
    {
        $this->logsPath = $path;

        $this->faker = FakerFactory::create();
    }

    /**
     * @param int $recordsCount
     */
    public function generateLogFile(string $fileName, int $recordsCount)
    {
        $fileStream = fopen($fileName, 'w');

        $dateTime = Carbon::now()->subDays(10);
        // Calculate step in seconds from date start to now
        $secondsIncrement = round($dateTime->diffInSeconds(Carbon::now()) / $recordsCount);

        for ($i = 0; $i < $recordsCount; $i++) {
            $dateStr = $dateTime->toDateTimeString();
            $userAgent = $this->faker->userAgent();
            $url = $this->faker->url();
            fwrite($fileStream, "{$dateStr} \"GET {$url} HTTP/1.1\" - \"{$userAgent}\"\r\n");

            $dateTime->addSeconds($secondsIncrement);
        }

        fclose($fileStream);
    }
}
