<?php
declare(strict_types = 1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/ExampleController.php';

const ROUTES_CACHE_FILE = __DIR__ . '/routes.php';

if (!is_file(ROUTES_CACHE_FILE)) {
    die('You have generate routes first!'.chr(10));
}

$routes = require_once ROUTES_CACHE_FILE;


$controllerFactory = new \Vertexbz\Router\Controller\Factory\BasicControllerFactory();
$controllerInvoker = new \Vertexbz\Router\Route\Invoker\ControllerInvoker($controllerFactory);

$middlewareFactory = new \Vertexbz\Router\Middleware\Factory\MiddlewareFactory();
$middlewareInvoker = new \Vertexbz\Router\Route\Invoker\MiddlewareInvoker($middlewareFactory, $controllerInvoker);

$middlewareInvoker->appendGlobalMiddleware(\Vertexbz\Router\Middleware\ExceptionCachingMiddleware::class);

$routeResolver = new \Vertexbz\Router\RouteResolver\HttpRouteResolver($routes, $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
$requestFactory = new \Vertexbz\Router\Request\Factory\BasicRequestFactory();

$router = new \Vertexbz\Router\Router($routeResolver, $requestFactory, $middlewareInvoker);
$router->run();

