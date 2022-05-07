<?php

namespace App\Http\Criteria;

use Doctrine\Common\Collections\Criteria;

interface RequestCriteriaInterface
{
    /**
     * @return Criteria
     */
    public function getCriteria(): Criteria;

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
     * @param string $defaultField
     * @param string $defaultOrder
     * @return array
     */
    public function getOrderBy(string $defaultField = '', string $defaultOrder = 'asc'): array;
}
