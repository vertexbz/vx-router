<?php
declare(strict_types = 1);
namespace Router\RequestResponseFactory;

use Router\Route;

trait UrlParamsExtractorTrait
{
    /**
     * @param Route $route
     * @param string $url
     * @return array
     */
    protected function extractRouteParams(Route $route, string $url): array
    {
        $params = $route->getDefaultParams();
        if ($match = preg_match($route->getRegEx(), $url, $matches)) {
            foreach ($route->getParamNames() as $paramName) {
                $params[$paramName] = $matches[$paramName];
            }
        }
        return $params;
    }
}
