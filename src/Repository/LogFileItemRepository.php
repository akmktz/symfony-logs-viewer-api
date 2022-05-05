<?php

namespace App\Repository;

use App\Entity\LogFileItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogFileItem>
 *
 * @method LogFileItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogFileItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogFileItem[]    findAll()
 * @method LogFileItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogFileItemRepository extends ServiceEntityRepository
{
    use PaginationTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogFileItem::class);
    }

    /**
     * @param LogFileItem $entity
     * @param bool $flush
     */
    public function add(LogFileItem $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param LogFileItem $entity
     * @param bool $flush
     */
    public function remove(LogFileItem $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
