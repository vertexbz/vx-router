<?php
declare(strict_types=1);
namespace Vertexbz\Router\Route\Invoker;

use Vertexbz\Router\Controller\Factory\ControllerFactoryInterface;
use Vertexbz\Router\Request\RequestInterface;
use Vertexbz\Router\Response\ResponseInterface;
use Vertexbz\Router\Route\Route;

class ControllerInvoker implements RouteInvokerInterface
{
    /**
     * @var ControllerFactoryInterface
     */
    protected $controllerFactory;

    /**
     * @param ControllerFactoryInterface $controllerFactory
     */
    public function __construct(ControllerFactoryInterface $controllerFactory)
    {
        $this->controllerFactory = $controllerFactory;
    }

    /**
     * @param RequestInterface $request
     * @param Route $route
     * @return ResponseInterface
     */
    public function invoke(RequestInterface $request, Route $route): ResponseInterface
    {
        $controller = $this->controllerFactory->createController($route);

        return $controller->{$route->getControllerAction()}($request);
    }
}
