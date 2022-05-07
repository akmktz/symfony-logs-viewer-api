<?php

namespace App\Repository;

use Doctrine\Common\Collections\Criteria;

trait PaginationTrait
{
    /**
     * @param int $page
     * @param int|null $perPage
     * @param Criteria|null $criteria
     * @param array|null $orderBy
     * @return array
     */
    public function paginate(int $page = 1, int $perPage = 10, array $orderBy = [], Criteria $criteria = null): array
    {
        if (!$criteria) {
            $criteria = Criteria::create();
        }

        $limit = $perPage;
        $offset = ($page - 1) * $perPage;
        $total = (int)$this->createQueryBuilder('items')
            ->select('count(items.id)')
            ->addCriteria($criteria)
            ->getQuery()
            ->getSingleScalarResult();
        $pagesCount = $total / $perPage;
        $pagesCount = (int)floor(fmod($pagesCount, 1) > 0 ? ($pagesCount + 1) : $pagesCount);

        $criteria->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy($orderBy);

        $data = $this->matching($criteria)
            ->map(
                fn ($item) => $this->convertEntityToArray($item)
            )
            ->toArray();

        $paginator = [
            'page' => $page,
            'per_page' => $perPage,
            'total_items' => $total,
            'total_pages' => $pagesCount,
        ];

        return compact('data', 'paginator');
    }

    /**
     * @param mixed $entity
     * @return array
     */
    protected function convertEntityToArray(mixed $entity): array
    {
        if (is_object($entity) && method_exists($entity, 'toArray')) {
            return $entity->toArray();
        }

        return $entity;
    }
}
