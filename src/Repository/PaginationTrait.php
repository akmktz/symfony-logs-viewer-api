<?php

namespace App\Repository;

use App\Http\Criteria\RequestCriteriaInterface;
use Doctrine\Common\Collections\Criteria;

trait PaginationTrait
{
    /**
     * @param int $page
     * @param int $perPage
     * @param string $sort
     * @param string $order
     * @param Criteria|null $criteria
     * @param RequestCriteriaInterface|null $requestCriteria
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function paginate(
        int $page = 1,
        int $perPage = 10,
        string $sort = '',
        string $order = '',
        Criteria $criteria = null,
        RequestCriteriaInterface $requestCriteria = null
    ): array
    {

        $limit = $perPage;
        $offset = ($page - 1) * $perPage;

        // Calculate total rows count
        $query = $this->createQueryBuilder('items');
        if ($criteria) {
            $query->addCriteria($criteria);
        }
        if ($requestCriteria instanceof RequestCriteriaInterface) {
            $requestCriteria->applyToQueryBuilder($query);
        }
        $total = (int)$query->select('count(items.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $pagesCount = $total / $perPage;
        $pagesCount = (int)floor(fmod($pagesCount, 1) > 0 ? ($pagesCount + 1) : $pagesCount);

        // Get data
        $query = $this->createQueryBuilder('items');
        if ($criteria) {
            $query->addCriteria($criteria);
        }
        if ($requestCriteria instanceof RequestCriteriaInterface) {
            $requestCriteria->applyToQueryBuilder($query);
        }
        $data = $query->select('items')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('items.' . $sort, $order)
            ->getQuery()
            ->getResult();

        $data = array_map(fn ($item) => $this->convertEntityToArray($item), $data);

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
