<?php

namespace App\Repository;

trait PaginationTrait
{
    /**
     * @param int $page
     * @param int|null $perPage
     * @param array $criteria
     * @param array|null $orderBy
     * @return array
     */
    public function paginate(int $page = 1, ?int $perPage = 10, array $criteria = [], ?array $orderBy = null): array
    {
        $limit = $perPage;
        $offset = ($page - 1) * $perPage;
        $total = $this->count($criteria);
        $pagesCount = $total / $perPage;
        $pagesCount = floor(fmod($pagesCount, 1) > 0 ? ($pagesCount + 1) : $pagesCount);

        $data = array_map(
            fn ($item) => $this->convertEntityToArray($item),
            $this->findBy($criteria, $orderBy, $limit, $offset)
        );

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
