<?php
declare(strict_types=1);
namespace Router\Exception;

use Router\Request\RequestInterface;

class RouteNotFoundException extends RouterException
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * RouteNotFoundException constructor.
     * @param string $message
     * @param RequestInterface $request
     */
    public function __construct($message, RequestInterface $request)
    {
        parent::__construct($message, 404, null);
        $this->request = $request;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
