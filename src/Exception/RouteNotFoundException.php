<?php
declare(strict_types=1);
namespace Vertexbz\Router\Exception;

class RouteNotFoundException extends RouterException
{
    /**
     * RouteNotFoundException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, 404);
    }
}
