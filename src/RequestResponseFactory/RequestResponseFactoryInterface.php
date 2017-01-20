<?php
declare(strict_types = 1);
namespace Router\RequestResponseFactory;

use Router\Request\RequestInterface;
use Router\Response\ResponseInterface;
use Router\Route;

interface RequestResponseFactoryInterface
{
    /**
     * @param Route $route
     * @return RequestInterface
     */
    public function createRequest(Route $route): RequestInterface;

    /**
     * @param $route
     * @param $request
     * @return ResponseInterface
     */
    public function createResponse(Route $route, RequestInterface $request): ResponseInterface;
}
