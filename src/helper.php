<?php
declare(strict_types=1);
namespace Vertexbz\Router;

use Vertexbz\Router\Response\BasicHttpResponse;
use Vertexbz\Router\Response\ResponseInterface;

if (!function_exists('\Vertexbz\Router\response')) {
    function response(string $body = '', int $code = 200, array $headers = []): BasicHttpResponse {
        $basicHttpResponse = new BasicHttpResponse();
        $basicHttpResponse->setResponseCode($code);
        !empty($body) && $basicHttpResponse->setBody($body);
        foreach ($headers as $name => $value) {
            $basicHttpResponse->addHeader($name, $value);
        }
        return $basicHttpResponse;
    }
}
