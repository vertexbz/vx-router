<?php
declare(strict_types=1);

namespace Vertexbz\Router\Request\Factory;

use Vertexbz\Router\Request\BasicHttpRequest;
use Vertexbz\Router\Request\Factory\Traits\UrlParamsExtractorTrait;
use Vertexbz\Router\Request\RequestInterface;
use Vertexbz\Router\Route\Route;

class BasicRequestFactory implements RequestFactoryInterface
{
    use UrlParamsExtractorTrait;

    /**
     * @param \Vertexbz\Router\Route\Route $route
     * @return RequestInterface
     */
    public function createRequest(Route $route): RequestInterface
    {
        $params = $this->extractRouteParams($route, strval($_SERVER['REQUEST_URI']));
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
}
