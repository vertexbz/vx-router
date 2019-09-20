<?php
declare(strict_types=1);
namespace Vertexbz\Router\Middleware;

use Vertexbz\Router\Request\RequestInterface;
use Vertexbz\Router\Response\ResponseInterface;
use Vertexbz\Router\Route\Invoker\MiddlewareInvoker;

interface MiddlewareInterface
{
    public function process(RequestInterface $request, MiddlewareInvoker $next): ResponseInterface;
}
