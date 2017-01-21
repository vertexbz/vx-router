<?php
declare(strict_types=1);
namespace Router\RequestResponseFactory;

use Router\Request\BasicHttpRequest;
use Router\Request\RequestInterface;
use Router\Response\BasicHttpResponse;
use Router\Response\ResponseInterface;
use Router\Route;

class BasicRequestResponseFactory implements RequestResponseFactoryInterface
{
    use UrlParamsExtractorTrait;

    /**
     * @param Route $route
     * @return RequestInterface
     */
    public function createRequest(Route $route): RequestInterface
    {
        $requestClass = $route->getRequestClass() ?: BasicHttpRequest::class;
        return new $requestClass(
            $_GET,
            $_POST,
            $_COOKIE,
            $_SERVER,
            getallheaders() ?: [],
            $this->extractRouteParams($route, $_SERVER['REQUEST_URI'])
        );
    }

    /**
     * @param Route $route
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function createResponse(Route $route, RequestInterface $request): ResponseInterface
    {
        $responseClass = $route->getResponseClass() ?: BasicHttpResponse::class;
        return new $responseClass();
    }
}
