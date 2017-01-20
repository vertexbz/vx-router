<?php
declare(strict_types=1);
namespace Router\Exception;

class BadRequestMethodException extends RouterException
{
    /**
     * BadRequestMethodException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, 400, null);
    }
}
