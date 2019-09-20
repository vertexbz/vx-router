<?php
declare(strict_types=1);
namespace Vertexbz\Router\Route\Invoker;

use Vertexbz\Router\Request\RequestInterface;
use Vertexbz\Router\Response\ResponseInterface;
use Vertexbz\Router\Route\Route;

interface RouteInvokerInterface
{
    /**
     * @param RequestInterface $request
     * @param Route $route
     * @return ResponseInterface
     */
    public function invoke(RequestInterface $request, Route $route): ResponseInterface;
}
