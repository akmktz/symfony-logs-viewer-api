<?php

namespace App\Tests\Unit;

use App\Entity\LogFile;
use App\Entity\LogFileItem;
use App\Http\Criteria\RequestCriteria;
use App\Manager\LogFileItemManager;
use App\Manager\LogFileManager;
use App\Repository\LogFileItemRepository;
use App\Repository\LogFileRepository;
use App\Service\SQLDBCache\SQLDBLogCacheService;
use App\Service\TestLogFile\TestLogFileService;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

class SQLDBLogCacheServiceTest extends KernelTestCase
{
    protected TestLogFileService $logService;
    protected SQLDBLogCacheService $cacheService;

    protected LogFileManager $logFileManager;
    protected LogFileItemManager $logFileItemManager;

    protected LogFileRepository $logRepository;
    protected LogFileItemRepository $logItemsRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $logFilesPath = static::getContainer()->getParameter('logs.path');
        $this->logService = new TestLogFileService($logFilesPath);

        $entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $this->logFileManager = new LogFileManager($entityManager);
        $this->logFileItemManager = new LogFileItemManager($entityManager);
        $this->cacheService = new SQLDBLogCacheService(
            $this->logFileManager,
            $this->logFileItemManager,
            $entityManager
        );

        $this->logRepository = $entityManager->getRepository(LogFile::class);
        $this->logItemsRepository = $entityManager->getRepository(LogFileItem::class);
    }

    public function testCacheInDatabase(): void
    {
        $log = $this->logFileManager->make('first_test_file.log');
        $log->setCachedSize(63); // Skip first row
        $this->logFileManager->save($log);

        $iterator = $this->logService->getLogData('first_test_file.log');
        $this->cacheService->checkAndUpdate('first_test_file.log', $iterator);

        $this->assertEquals($this->logRepository->count([]), 1);
        $this->assertEquals($this->logItemsRepository->count([]), 2);
    }

    public function testGetPaginatedLogItems(): void
    {
        $log = $this->logFileManager->create('first_test_file.log');
        $date = Carbon::now();
        $data = 'TestGetPaginatedLogItems';
        $this->logFileItemManager->create($log, $date, $data);
        $requestCriteria = new RequestCriteria(new Request());
        $result = $this->cacheService->getPaginatedLogItems('first_test_file.log', $requestCriteria);

        $this->assertEquals($this->logItemsRepository->count([]), 1);
        $this->assertEquals($result, [
            'data' => [
                [
                    'date_time' => $date,
                    'data' => $data,
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
