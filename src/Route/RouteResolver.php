<?php
namespace Router\Route;

use Router\Exception\BadRequestMethodException;
use Router\Exception\RouteNotFoundException;

class RouteResolver
{
    /**
     * @var RouterConfig
     */
    protected $routerConfig;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param RouterConfig $routerConfig
     */
    public function __construct(RouterConfig $routerConfig)
    {
        $this->routerConfig = $routerConfig;
    }

    /**
     * @param Request $request
     * @return Route
     */
    public function resolveRouteForRequest(Request $request)
    {
        $routes = $this->getRoutesConfig();
        list ($matchedRoute, $routeParameters) = $this->findMatchingRoute($routes, $request);
        return new Route($matchedRoute, $routeParameters);
    }

    /**
     * @return array
     */
    protected function getRoutesConfig()//todo ladniej
    {
        return require $this->routerConfig->routesDir . '/routes.php';
    }

    /**
     * @param string $uri
     * @return string
     */
    protected function stripQueryFromUri($uri)
    {
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }
        return $uri;
    }

    /**
     * @param string $uri
     * @return string
     */
    protected function stripLastSlash($uri)
    {
        return preg_replace('|/$|', '', $uri);
    }

    /**
     * @param array $routes
     * @param Request $request
     * @return array
     * @throws BadRequestMethodException
     * @throws RouteNotFoundException
     */
    protected function findMatchingRoute(array $routes, Request $request)
    {
        return $this->findRouteMatchingCriteria(
            $routes,
            $this->stripLastSlash($this->stripQueryFromUri($request->getRequestUri())),
            $request->getMethod()
        );
    }

    /**
     * @param array $routes
     * @param string $uri
     * @param string $method
     * @return array
     * @throws BadRequestMethodException
     * @throws RouteNotFoundException
     */
    protected function findRouteMatchingCriteria($routes, $uri, $method)
    {
        $matchedRoute = false;
        $extractedVariables = [];
        foreach ($routes as $route) {
            if ($this->routeMatchesUri($route, $uri, $extractedVariables)) {
                $matchedRoute = true;
                if ($this->routeMethodMatchesMethod($route, $method)) {
                    return [$route, $extractedVariables];
                }
            }
        }
        if ($matchedRoute) {
            throw new BadRequestMethodException();
        } else {
            throw new RouteNotFoundException;
        }
    }

    /**
     * @param array $route
     * @param $uri string
     * @param array $extractedParameters
     * @return bool
     */
    public function routeMatchesUri(array $route, $uri, array &$extractedParameters = [])
    {
        if ($match = preg_match($route['regex'], $uri, $matches)) {
            if (func_num_args() > 2) {
                $extractedParameters = [];
                foreach ($route['parameters'] as $paramName) {
                    $extractedParameters[$paramName] = $matches[$paramName];
                }
            }
        }
        return $match;
    }

    /**
     * @param array $route
     * @param $method string
     * @return bool
     */
    protected function routeMethodMatchesMethod(array $route, $method)
    {
        return in_array($method, $route['httpMethods']);
    }

    /**
     * @param string $routeName
     * @return Route
     * @throws RouteNotFoundException
     */
    public function getNamedRoute($routeName)
    {
        $routes = $this->getRoutesConfig();
        $matchedRoute = $this->findMatchingRouteByName($routes, $routeName);
        return new Route($matchedRoute, $matchedRoute['parameters']);
    }

    /**
     * @param array $routes
     * @param string $name
     * @return array
     * @throws BadRequestMethodException
     * @throws RouteNotFoundException
     */
    protected function findMatchingRouteByName($routes, $name)
    {
        foreach ($routes as $route) {
            if ($this->routeMatchesName($route, $name)) {
                return $route;
            }
        }
        throw new RouteNotFoundException;
    }

    /**
     * @param array $route
     * @param string $name
     * @return bool
     */
    protected function routeMatchesName(array $route, $name)
    {
        if (isset($route['names'])) {
            foreach ($route['names'] as $routeName) {
                if (strcasecmp($routeName, $name) === 0) {
                    return true;
                }
            }
        }
        return false;
    }
}
