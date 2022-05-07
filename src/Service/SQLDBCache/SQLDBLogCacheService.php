<?php

namespace App\Service\SQLDBCache;

use App\Entity\LogFileItem;
use App\Http\Criteria\RequestCriteriaInterface;
use App\Manager\LogFileItemManager;
use App\Manager\LogFileManager;
use App\Service\LogCacheInterface;
use App\Service\LogIteratorInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class SQLDBLogCacheService implements LogCacheInterface
{
    /**
     * @var LogFileManager
     */
    protected LogFileManager $logFileManager;

    /**
     * @var LogFileItemManager
     */
    protected LogFileItemManager $logFileItemManager;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(
        LogFileManager $logFileManager,
        LogFileItemManager $logFileItemManager,
        EntityManagerInterface $entityManager
    ) {
        $this->logFileManager = $logFileManager;
        $this->logFileItemManager = $logFileItemManager;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $logName
     * @return array
     */
    public function getPaginatedLogItems(string $logName, RequestCriteriaInterface $requestCriteria): array
    {
        $log = $this->logFileManager->findByName($logName);
        $logItemsRepository = $this->entityManager->getRepository(LogFileItem::class);

        $page = $requestCriteria->getPage();
        $perPage = $requestCriteria->getPerPage(10);
        $sort = $requestCriteria->getSort('id');
        $order = $requestCriteria->getOrder('desc');

        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()->eq('log_file_id', $log));

        return $logItemsRepository->paginate($page, $perPage, $sort, $order, $criteria, $requestCriteria);
    }

    public function checkAndUpdate(string $logName, LogIteratorInterface $iterator): void
    {
        $log = $this->logFileManager->findByNameOrCreate($logName);
        $logSize = $iterator->getSize();
        if ($logSize <= $log->getCachedSize()) {
            return;
        }

        $iterator->goto($log->getCachedSize());

        while ($iterator->valid()) {
            $dto = $iterator->current();
            $data = $dto->getString();
            if ($data) {
                $logItem = $this->logFileItemManager->make($log, $dto->getDateTime(), $data);
                $this->entityManager->persist($logItem);
            }


            $iterator->next();
        }

        $log->setCachedSize($iterator->getSize());

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
