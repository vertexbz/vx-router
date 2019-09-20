<?php
declare(strict_types=1);
namespace Vertexbz\Router;

use Vertexbz\Router\Request\Factory\RequestFactoryInterface;
use Vertexbz\Router\Response\ResponseInterface;
use Vertexbz\Router\Route\Invoker\RouteInvokerInterface;
use Vertexbz\Router\RouteResolver\RouteResolverInterface;

class Router
{
    /**
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * @var RouteResolverInterface
     */
    protected $routeResolver;

    /**
     * @var RouteInvokerInterface
     */
    protected $routeInvoker;

    /**
     * @param RouteResolverInterface $routeResolver
     * @param RequestFactoryInterface $requestFactory
     * @param RouteInvokerInterface $routeInvoker
     */
    public function __construct(
        RouteResolverInterface $routeResolver,
        RequestFactoryInterface $requestFactory,
        RouteInvokerInterface $routeInvoker
    )
    {
        $this->routeResolver = $routeResolver;
        $this->requestFactory = $requestFactory;
        $this->routeInvoker = $routeInvoker;
    }

    /**
     *
     */
    public function run(): void
    {
        $route = $this->routeResolver->resolveRoute();
        $request = $this->requestFactory->createRequest($route);

        $response = $this->routeInvoker->invoke($request, $route);

        $this->sendResponseHeaders($response);
        $this->sendResponseBody($response);
    }

    /**
     * @param ResponseInterface $response
     */
    protected function sendResponseHeaders(ResponseInterface $response): void
    {
        http_response_code($response->getCode());
        foreach ($response->getHeaders() as $header => $value) {
            if (is_array($value)) {
                foreach ($value as $singleValue) {
                    header($header.': '.$singleValue, false);
                }
            } else {
                header($header.': '.$value);
            }
        }
    }

    /**
     * @param ResponseInterface $response
     */
    protected function sendResponseBody(ResponseInterface $response): void
    {
        echo $response->render();
    }
}
