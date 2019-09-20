<?php
declare(strict_types = 1);

use Vertexbz\Router\Controller\ControllerInterface;
use Vertexbz\Router\Request\BasicHttpRequest;
use function Vertexbz\Router\response;
use Vertexbz\Router\Response\BasicHttpResponse;

class ExampleController implements ControllerInterface
{
    /**
     * @route /
     * @param BasicHttpRequest $request
     * @return BasicHttpResponse
     */
    public function exampleAction(BasicHttpRequest $request): BasicHttpResponse
    {
        return response('Hello World!');
    }

    /**
     * @route /middleware
     * @middleware ExceptionHandlingMiddleware
     *
     * @param BasicHttpRequest $request
     * @return BasicHttpResponse
     * @throws \Exception
     */
    public function middlewareAction(BasicHttpRequest $request): BasicHttpResponse
    {
        throw new \Exception("Exception message", 418);
    }
}
