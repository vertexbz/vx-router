<?php
declare(strict_types = 1);
namespace Router\ControllerFactory;

use Router\Controller\ControllerInterface;
use Router\Route;

interface ControllerFactoryInterface
{
    /**
     * @param Route $route
     * @return ControllerInterface
     */
    public function createController(Route $route): ControllerInterface;
}
