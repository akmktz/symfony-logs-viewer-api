<?php

namespace App\Http\Criteria;

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;

class RequestCriteria implements RequestCriteriaInterface
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Criteria
     */
    public function getCriteria(): Criteria
    {
        $criteria = Criteria::create();

        $search = $this->request->get('search');
        if ($search) {
            $criteria->andWhere(Criteria::expr()->contains('data', $search));
        }

        return $criteria;
    }

    /**
     * @param int $default
     * @return int|null
     */
    public function getPage(int $default = 1): ?int
    {
        $page = $this->request->get('page');

        if (!is_numeric($page)) {
            return $default;
        }

        return $page;
    }

    /**
     * @param int $default
     * @return int|null
     */
    public function getPerPage(int $default = 10): ?int
    {
        $page = $this->request->get('per_page');

        if (!is_numeric($page)) {
            return $default;
        }

        return $page;
    }

    /**
     * @param string $defaultField
     * @param string $defaultOrder
     * @return array
     */
    public function getOrderBy(string $defaultField = '', string $defaultOrder = 'asc'): array
    {
        $sortField = $this->request->get('sort', $defaultField);
        $sortOrder = $this->request->get('order', $defaultOrder);

        if (!$sortField) {
            return [];
        }

        return [
            $sortField => $sortOrder,
        ];
    }
}
