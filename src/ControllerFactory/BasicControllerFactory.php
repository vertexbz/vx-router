<?php
declare(strict_types = 1);
namespace Router\ControllerFactory;

use Router\Controller\ControllerInterface;
use Router\Route;

class BasicControllerFactory implements ControllerFactoryInterface
{
    /**
     * @param Route $route
     * @return ControllerInterface
     */
    public function createController(Route $route): ControllerInterface
    {
        $controllerClass = $route->getControllerClass();
        return new $controllerClass();
    }
}
