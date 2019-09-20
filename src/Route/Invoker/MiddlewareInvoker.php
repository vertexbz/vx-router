<?php
declare(strict_types=1);
namespace Vertexbz\Router\Route\Invoker;

use Vertexbz\Router\Exception\InvalidMiddlewareException;
use Vertexbz\Router\Middleware\Factory\MiddlewareFactoryInterface;
use Vertexbz\Router\Middleware\MiddlewareInterface;
use Vertexbz\Router\Request\RequestInterface;
use Vertexbz\Router\Response\ResponseInterface;
use Vertexbz\Router\Route\Route;

class MiddlewareInvoker implements RouteInvokerInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    protected $middlewareChain;
    /**
     * @var Route
     */
    protected $route;

    /**
     * @var MiddlewareFactoryInterface
     */
    protected $middlewareFactory;
    /**
     * @var RouteInvokerInterface
     */
    protected $controllerInvoker;
    /**
     * @var MiddlewareInterface[]
     */
    protected $globalMiddlewares = [];

    /**
     * MiddlewareInvoker constructor.
     * @param MiddlewareFactoryInterface $middlewareFactory
     * @param RouteInvokerInterface $controllerInvoker
     */
    public function __construct(
        MiddlewareFactoryInterface $middlewareFactory,
        RouteInvokerInterface $controllerInvoker
    )
    {
        $this->middlewareFactory = $middlewareFactory;
        $this->controllerInvoker = $controllerInvoker;
    }

    /**
     * @param $middleware
     * @throws InvalidMiddlewareException
     */
    public function appendGlobalMiddleware($middleware): void
    {
        if (!is_string($middleware) && !$middleware instanceof MiddlewareInterface) {
            throw new InvalidMiddlewareException("Middleware must be a string or an instance of ".MiddlewareInterface::class);
        }
        $this->globalMiddlewares[] = $middleware;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request): ResponseInterface
    {
        $middleware = array_shift($this->middlewareChain);
        if (null === $middleware) {
            return $this->controllerInvoker->invoke($request, $this->route);
        } else {
            if (!$middleware instanceof MiddlewareInterface) {
                $middleware = $this->middlewareFactory->createMiddleware($middleware);
            }
            return $middleware->process($request, $this);
        }
    }

    /**
     * @param RequestInterface $request
     * @param \Vertexbz\Router\Route\Route $route
     * @return ResponseInterface
     */
    public function invoke(RequestInterface $request, Route $route): ResponseInterface
    {
        $this->route = $route;
        $this->middlewareChain = array_merge($this->globalMiddlewares, $route->getMiddlewares());
        return $this($request);
    }
}
