<?php
declare(strict_types=1);
namespace Vertexbz\Router\Exception;

class BadRequestMethodException extends RouterException
{
    /**
     * BadRequestMethodException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }
}
