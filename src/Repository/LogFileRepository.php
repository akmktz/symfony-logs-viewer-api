<?php

namespace App\Repository;

use App\Entity\LogFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogFile>
 *
 * @method LogFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogFile[]    findAll()
 * @method LogFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogFile::class);
    }

    /**
     * @param LogFile $entity
     * @param bool $flush
     */
    public function add(LogFile $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param LogFile $entity
     * @param bool $flush
     */
    public function remove(LogFile $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
