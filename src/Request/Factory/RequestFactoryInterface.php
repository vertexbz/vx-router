<?php
declare(strict_types = 1);
namespace Vertexbz\Router\Request\Factory;

use Vertexbz\Router\Request\RequestInterface;
use Vertexbz\Router\Route\Route;

interface RequestFactoryInterface
{
    /**
     * @param \Vertexbz\Router\Route\Route $route
     * @return RequestInterface
     */
    public function createRequest(Route $route): RequestInterface;
}
