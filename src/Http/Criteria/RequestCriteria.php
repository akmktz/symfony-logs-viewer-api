<?php

namespace App\Http\Criteria;

use Symfony\Component\HttpFoundation\Request;

class RequestCriteria implements RequestCriteriaInterface
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getCriteria(): array
    {
        $criteria = [];

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
}
