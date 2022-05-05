<?php

namespace App\Http\Criteria;

interface RequestCriteriaInterface
{
    /**
     * @return array
     */
    public function getCriteria(): array;

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
}
