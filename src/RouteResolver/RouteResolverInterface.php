<?php
declare(strict_types = 1);

namespace Vertexbz\Router\RouteResolver;

use Vertexbz\Router\Exception\BadRequestMethodException;
use Vertexbz\Router\Exception\RouteNotFoundException;
use Vertexbz\Router\Route\Route;

interface RouteResolverInterface
{
    /**
     * @param string $routeName
     * @return Route
     * @throws RouteNotFoundException
     */
    public function getNamedRoute(string $routeName): Route;

    /**
     * @return Route
     * @throws BadRequestMethodException
     * @throws RouteNotFoundException
     */
    public function resolveRoute(): Route;
}
