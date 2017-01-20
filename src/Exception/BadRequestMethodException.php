<?php
declare(strict_types=1);
namespace Router\Exception;

use Router\Request\RequestInterface;
use Router\Route\Route;

class BadRequestMethodException extends RouterException
{
    /**
     * @var Route
     */
    protected $route;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * BadRequestMethodException constructor.
     * @param string $message
     * @param RequestInterface $request
     * @param Route $route
     */
    public function __construct($message, RequestInterface $request, Route $route)
    {
        parent::__construct($message, 400, null);
        $this->route = $route;
        $this->request = $request;
    }

    /**
     * @return Route
     */
    public function getRoute(): Route
    {
        return $this->route;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
