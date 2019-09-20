<?php
declare(strict_types=1);
namespace Vertexbz\Router\RouteResolver;

use Vertexbz\Router\Exception\BadRequestMethodException;
use Vertexbz\Router\Exception\RouteNotFoundException;
use Vertexbz\Router\Route\Route;

class HttpRouteResolver implements RouteResolverInterface
{
    /**
     * @var array
     */
    protected $routes;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $method;

    /**
     * @param array $routes
     * @param $url
     * @param $method
     */
    public function __construct(array $routes, $url, $method)
    {
        $this->routes = $routes;
        $this->url = $url;
        $this->method = $method;
    }

    /**
     * @param string $routeName
     * @return Route
     * @throws RouteNotFoundException
     */
    public function getNamedRoute(string $routeName): Route
    {
        foreach ($this->routes as $routeData) {
            if ($this->routeMatchesName($routeData, $routeName)) {
                return new Route($routeData);
            }
        }
        throw new RouteNotFoundException("Cannot find route with name [{$routeName}]!");
    }

    /**
     * @return Route
     * @throws BadRequestMethodException
     * @throws RouteNotFoundException
     */
    public function resolveRoute(): Route
    {
        $matchedRoute = false;
        foreach ($this->routes as $routeData) {
            if (preg_match($routeData[Route::REGEX], $this->url) == 1) {
                $matchedRoute = true;
                if (in_array($this->method, $routeData[Route::METHODS])) {
                    return new Route($routeData);
                }
            }
        }

        if ($matchedRoute) {
            throw new BadRequestMethodException("Unsupported request method [{$this->method}] for url [{$this->url}]!");
        } else {
            throw new RouteNotFoundException("Cannot find route for url [{$this->url}], method [{$this->method}]!");
        }
    }

    /**
     * @param string $url
     * @return string
     */
    protected function cleanUpUrl(string $url): string
    {
        $url = rtrim($url, '/');
        if (($pos = strpos('?', $url)) !== false) {
            $url = substr($url, $pos);
        }
        return $url;
    }

    /**
     * @param array  $routeData
     * @param string $name
     * @return bool
     */
    protected function routeMatchesName(array $routeData, string $name): bool
    {
        foreach ($routeData[Route::NAMES] ?? [] as $routeName) {
            if (strcasecmp($routeName, $name) === 0) {
                return true;
            }
        }
        return false;
    }

}
