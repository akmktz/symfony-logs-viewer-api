<?php

namespace App\Manager;

use App\Entity\LogFile;
use App\Entity\LogFileItem;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;

class LogFileItemManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $id
     * @return LogFileItem|null
     */
    public function findById(int $id): ?LogFileItem
    {
        $logFileItemRepository = $this->entityManager->getRepository(LogFileItem::class);

        return $logFileItemRepository->find($id);
    }

    /**
     * @param LogFile $logFile
     * @param Carbon $date
     * @param string $data
     * @return LogFileItem
     */
    public function make(LogFile $logFile, Carbon $date, string $data): LogFileItem
    {
        $logItem = new LogFileItem();
        $logItem->setLogFileId($logFile);
        $logItem->setDateTime($date);
        $logItem->setData($data);

        return $logItem;
    }

    /**
     * @param LogFileItem $logItem
     * @return LogFileItem
     */
    public function save(LogFileItem $logItem): LogFileItem
    {
        $this->entityManager->persist($logItem);
        $this->entityManager->flush();

        return $logItem;
    }

    /**
     * @param LogFile $logFile
     * @param Carbon $date
     * @param string $data
     * @return LogFileItem
     */
    public function create(LogFile $logFile, Carbon $date, string $data): LogFileItem
    {
        $logItem = $this->make($logFile, $date, $data);
        $this->save($logItem);

        return $logItem;
    }
}
