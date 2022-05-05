<?php

namespace App\Manager;

use App\Entity\LogFile;
use Doctrine\ORM\EntityManagerInterface;

class LogFileManager
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
     * @return LogFile|null
     */
    public function findById(int $id): ?LogFile
    {
        $logFileRepository = $this->entityManager->getRepository(LogFile::class);

        return $logFileRepository->find($id);
    }

    /**
     * @param string $name
     * @return LogFile|null
     */
    public function findByName(string $name): ?LogFile
    {
        $logFileRepository = $this->entityManager->getRepository(LogFile::class);

        return $logFileRepository->findOneBy(['log_name' => $name]);
    }

    /**
     * @param string $name
     * @return LogFile
     */
    public function make(string $name): LogFile
    {
        $log = new LogFile();
        $log->setLogName($name);

        return $log;
    }

    /**
     * @param LogFile $log
     * @return LogFile
     */
    public function save(LogFile $log): LogFile
    {
        $this->entityManager->persist($log);
        $this->entityManager->flush();

        return $log;
    }

    /**
     * @param string $name
     * @return LogFile
     */
    public function create(string $name): LogFile
    {
        $log = $this->make($name);
        $this->save($log);

        return $log;
    }

    /**
     * @param string $name
     * @return LogFile
     */
    public function findByNameOrCreate(string $name): LogFile
    {
        $log = $this->findByName($name);
        if (!$log) {
            $log = $this->create($name);
        }

        return $log;
    }

}
