<?php
declare(strict_types=1);
namespace Router\Exception;

class RouteNotFoundException extends RouterException
{
    /**
     * RouteNotFoundException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, 404, null);
    }
}
