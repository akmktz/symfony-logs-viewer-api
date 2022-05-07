<?php

namespace App\Http\Criteria;

use Doctrine\ORM\QueryBuilder;

interface RequestCriteriaInterface
{
    /**
     * @param QueryBuilder $query
     */
    public function applyToQueryBuilder(QueryBuilder &$query): void;

    /**
     * @param int $default
     * @return int|null
     */
    public function getPage(int $default = 1): ?int;

    /**
     * @param int $default
     * @return int|null
     */
    public function getPerPage(int $default = 10): ?int;

    /**
     * @param string $default
     * @return string
     */
    public function getSort(string $default = ''): string;

    /**
     * @param string $default
     * @return string
     */
    public function getOrder(string $default = ''): string;
}
