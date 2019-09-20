<?php
declare(strict_types=1);
namespace Vertexbz\Router\Middleware\Factory;

use Vertexbz\Router\Middleware\MiddlewareInterface;

class MiddlewareFactory implements MiddlewareFactoryInterface
{
    public function createMiddleware($middleware): MiddlewareInterface
    {
        return new $middleware();
    }
}
