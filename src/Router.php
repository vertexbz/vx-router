<?php
declare(strict_types=1);
namespace Router;

use Router\ControllerFactory\ControllerFactoryInterface;
use Router\Request\RequestInterface;
use Router\RequestResponseFactory\RequestResponseFactoryInterface;
use Router\Response\ResponseInterface;
use Router\RouteResolver\RouteResolverInterface;

class Router
{
    /**
     * @var RequestResponseFactoryInterface
     */
    protected $requestResponseFactory;

    /**
     * @var RouteResolverInterface
     */
    protected $routeResolver;

    /**
     * @var ControllerFactoryInterface
     */
    protected $controllerFactory;


    /**
     * @param RouteResolverInterface $routeResolver
     * @param RequestResponseFactoryInterface $requestResponseFactory
     * @param ControllerFactoryInterface $controllerFactory
     */
    public function __construct(
        RouteResolverInterface $routeResolver,
        RequestResponseFactoryInterface $requestResponseFactory,
        ControllerFactoryInterface $controllerFactory
    )
    {
        $this->routeResolver = $routeResolver;
        $this->requestResponseFactory = $requestResponseFactory;
        $this->controllerFactory = $controllerFactory;
    }

    /**
     *
     */
    public function run(): void
    {
        $route = $this->routeResolver->resolveRoute();
        $request = $this->requestResponseFactory->createRequest($route);

        $response = $this->execute($route, $request);

        $this->outputResponse($response);
    }

    /**
     * @param Route $route
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    protected function execute(Route $route, RequestInterface $request): ResponseInterface
    {
        $controller = $this->controllerFactory->createController($route);

        $response = $this->requestResponseFactory->createResponse($route, $request);
        $controller->{$route->getControllerAction()}($request, $response);

        return $response;
    }

    /**
     * @param ResponseInterface $response
     */
    protected function outputResponse(ResponseInterface $response): void
    {
        http_response_code($response->getHttpCode());
        foreach ($response->getHeaders() as $header => $value) {
            if (is_array($value)) {
                foreach ($value as $singleValue) {
                    header($header.': '.$singleValue);
                }
            } else {
                header($header.': '.$value);
            }
        }
        echo $response->render();
    }
}
