<?php

namespace App\Tests\Feature;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BaseTestCase extends ApiTestCase
{
    /**
     * Generates a URL from the given parameters.
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl(
        string $route,
        array $parameters = [],
        int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
    ): string
    {
        return static::getContainer()
            ->get('router')
            ->generate($route, $parameters, $referenceType);
    }
}
