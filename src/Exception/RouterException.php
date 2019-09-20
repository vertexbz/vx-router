<?php
declare(strict_types=1);
namespace Vertexbz\Router\Exception;

class RouterException extends \Exception
{
    /**
     * RouterException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code, null);
    }
}
