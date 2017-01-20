<?php
declare(strict_types = 1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/ExampleController.php';

const ROUTES_CACHE_FILE = __DIR__ . '/routes.php';

if (!is_file(ROUTES_CACHE_FILE)) {
    die('Y have generate route first!'.chr(10));
}

$routes = require_once ROUTES_CACHE_FILE;


$routeResolver = new \Router\RouteResolver\HttpRouteResolver($routes, $_SERVER);
$requestResponseFactory = new \Router\RequestResponseFactory\BasicRequestResponseFactory();
$controllerFactory = new \Router\ControllerFactory\BasicControllerFactory();

$router = new \Router\Router($routeResolver, $requestResponseFactory, $controllerFactory);
$router->run();

