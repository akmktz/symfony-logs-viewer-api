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

        if (!$this->request->get('search')) {
            return;
        }
        $searchStringList = (array)$this->request->get('search');
        if (empty($searchStringList)) {
            return;
        }

        $searchTypesList = (array)$this->request->get('search_type');
        $where = $query->expr()->orX();
        foreach ($searchStringList as $searchIndex => $searchString) {
            $searchType = $this->arrayGet($searchTypesList, $searchIndex);
            if ($searchType === 'regex') {
                $where->add("REGEXP({$alias}.data, :regex{$searchIndex}) = true");
                $query->setParameter("regex{$searchIndex}", $searchString);
            } else {
                $where->add("{$alias}.data LIKE :searchString{$searchIndex}");
                $query->setParameter("searchString{$searchIndex}", "%{$searchString}%");
            }
        }

        $query->andWhere($where);
    }

    /**
     * @param QueryBuilder $query
     */
    protected function applyPeriodToQueryBuilder(QueryBuilder &$query): void
    {
        [$alias] = $query->getRootAliases();

        if (!$this->request->get('from') && !$this->request->get('to')) {
            return;
        }

        $periodStartList = (array)$this->request->get('from');
        $periodEndList = (array)$this->request->get('to');
        $periodCount = max(count($periodStartList), count($periodEndList));
        $where = $query->expr()->orX();
        for ($periodIndex = 0; $periodIndex < $periodCount; $periodIndex++) {
            $periodStart = $this->arrayGet($periodStartList, $periodIndex);
            $subWhere = $query->expr()->andX();
            if ($periodStart) {
                $subWhere->add("{$alias}.date_time >= :periodStart{$periodIndex}");
                $query->setParameter("periodStart{$periodIndex}", Carbon::parse($periodStart));
            }
            $periodEnd = $this->arrayGet($periodEndList, $periodIndex);
            if ($periodEnd) {
                $subWhere->add("{$alias}.date_time <= :periodEnd{$periodIndex}");
                $query->setParameter("periodEnd{$periodIndex}", Carbon::parse($periodEnd));
            }
            $where->add($subWhere);
        }
        $query->andWhere($where);
    }

    /**
     * @param array $array
     * @param int|string $key
     * @param null $default
     * @return mixed
     */
    protected function arrayGet(array $array, int|string $key, $default = null): mixed
    {
        if (!array_key_exists($key, $array)) {
            return $default;
        }

        return $array[$key];
    }
}
