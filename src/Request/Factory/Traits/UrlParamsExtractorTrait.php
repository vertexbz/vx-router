<?php
declare(strict_types = 1);
namespace Vertexbz\Router\Request\Factory\Traits;

use Vertexbz\Router\Exception\RouterException;
use Vertexbz\Router\Route\Route;

trait UrlParamsExtractorTrait
{
    /**
     * @param \Vertexbz\Router\Route\Route $route
     * @param string $url
     * @return array
     * @throws RouterException
     */
    protected function extractRouteParams(Route $route, string $url): array
    {
        if (0 !== preg_match($route->getRegEx(), $url, $matches)) {
            return array_replace($route->getDefaultParams(),
                array_filter($matches, function ($item) {
                    return !is_int($item);
                }, ARRAY_FILTER_USE_KEY)
            );
        }
        throw new RouterException("Url doesn't match route!", 500);
    }
}
