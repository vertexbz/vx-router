<?php
declare(strict_types = 1);
namespace Vertexbz\Router\Controller\Factory;

use Vertexbz\Router\Controller\ControllerInterface;
use Vertexbz\Router\Route\Route;

class BasicControllerFactory implements ControllerFactoryInterface
{
    /**
     * @param Route $route
     * @return ControllerInterface
     */
    public function createController(Route $route): ControllerInterface
    {
        $controller = $route->getControllerClass();
        return new $controller();
    }
}
