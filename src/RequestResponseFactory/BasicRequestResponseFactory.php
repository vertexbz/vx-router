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
        $params = $this->extractRouteParams($route, $_SERVER['REQUEST_URI']);
        return new class($params) extends BasicHttpRequest {
            public function __construct(array $params)
            {
                $this->get = $_GET;
                $this->post = $_POST;
                $this->cookie = $_COOKIE;
                $this->server = $_SERVER;
                $this->headers = getallheaders();
                $this->params = $params;
            }
        };
    }

    /**
     * @param Route $route
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function createResponse(Route $route, RequestInterface $request): ResponseInterface
    {
        return new BasicHttpResponse();
    }
}
