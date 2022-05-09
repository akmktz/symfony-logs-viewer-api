<?php

namespace App\Http\Criteria;

use Carbon\Carbon;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class RequestCriteria implements RequestCriteriaInterface
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
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
     * @param string $default
     * @return string
     */
    public function getSort(string $default = ''): string
    {
        return $this->request->get('sort', $default);
    }

    /**
     * @param string $default
     * @return string
     */
    public function getOrder(string $default = ''): string
    {
        return $this->request->get('order', $default);
    }

    /**
     * @param QueryBuilder $query
     */
    public function applyToQueryBuilder(QueryBuilder &$query): void
    {
        $this->applySearchToQueryBuilder($query);
        $this->applyPeriodToQueryBuilder($query);
    }

    /**
     * @param QueryBuilder $query
     */
    protected function applySearchToQueryBuilder(QueryBuilder &$query): void
    {
        [$alias] = $query->getRootAliases();

        $search = $this->request->get('search');
        if (!$search) {
            return;
        }

        $searchType = $this->request->get('search_type');
        if ($searchType === 'regex') {
            $query->andWhere('REGEXP(' . $alias . '.data, :regex) = true')
                ->setParameter('regex', $search);

            return;
        }

        $query->andWhere($alias . '.data LIKE :value')
            ->setParameter('value', '%' . $search . '%');
    }

    /**
     * @param QueryBuilder $query
     */
    protected function applyPeriodToQueryBuilder(QueryBuilder &$query): void
    {
        [$alias] = $query->getRootAliases();

        if ($this->request->get('from')) {
            $periodStart = Carbon::parse($this->request->get('from'));

            $query->andWhere($alias . '.date_time >= :periodStart')
                ->setParameter('periodStart', $periodStart);
        }

        if ($this->request->get('to')) {
            $periodEnd = Carbon::parse($this->request->get('to'));

            $query->andWhere($alias . '.date_time <= :periodEnd')
                ->setParameter('periodEnd', $periodEnd);
        }
    }

}
