<?php
declare(strict_types=1);
namespace Vertexbz\Router\Middleware\Factory;

use Vertexbz\Router\Middleware\MiddlewareInterface;

interface MiddlewareFactoryInterface
{
    public function createMiddleware($middleware): MiddlewareInterface;
}
