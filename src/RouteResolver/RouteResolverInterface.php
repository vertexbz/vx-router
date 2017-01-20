<?php
declare(strict_types = 1);

namespace Router\RouteResolver;

use Router\Exception\BadRequestMethodException;
use Router\Exception\RouteNotFoundException;
use Router\Route;

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
