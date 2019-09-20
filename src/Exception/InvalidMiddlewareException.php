<?php
declare(strict_types=1);
namespace Vertexbz\Router\Exception;

class InvalidMiddlewareException extends RouterException
{
    /**
     * InvalidMiddlewareException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, 500);
    }
}
