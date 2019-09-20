<?php
declare(strict_types=1);

namespace Vertexbz\Router\Middleware;

use Vertexbz\Router\Exception\RouterException;
use Vertexbz\Router\Request\RequestInterface;
use Vertexbz\Router\Response\BasicHttpResponse;
use Vertexbz\Router\Response\ResponseInterface;
use Vertexbz\Router\Route\Invoker\MiddlewareInvoker;

class ExceptionCachingMiddleware implements MiddlewareInterface
{
    /**
     * @param RequestInterface $request
     * @param MiddlewareInvoker $next
     * @return ResponseInterface
     */
    public function process(RequestInterface $request, MiddlewareInvoker $next): ResponseInterface
    {
        try {
            return $next($request);
        } catch (\Throwable $t) {
            $basicHttpResponse = new BasicHttpResponse();
            $basicHttpResponse->setBody($t->getMessage());
            $code = 500;
            if ($t instanceof RouterException) {
                $code = $t->getCode();
            }
            $basicHttpResponse->setResponseCode($code);

            return $basicHttpResponse;
        }
    }
}
