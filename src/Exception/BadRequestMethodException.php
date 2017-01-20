<?php

namespace Router\Exception;

use Router\Route\Route;

class BadRequestMethodException extends RouterException
{
    /**
     * @var Route
     */
    protected $route;

    /**
     * BadRequestMethodException constructor.
     * @param string $message
     * @param Route $route
     */
    public function __construct($message, Route $route)//todo add Request too
    {
        parent::__construct($message, 400, null);
        $this->route = $route;
    }

    /**
     * @return Route
     */
    public function getRoute(): Route
    {
        return $this->route;
    }
}
