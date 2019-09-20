<?php
declare(strict_types=1);
namespace tests\Vertexbz\Router\Exception;

use PHPUnit\Framework\TestCase;
use Vertexbz\Router\Exception\RouterException;

/**
 * @covers \Vertexbz\Router\Exception\RouterException
 */
class RouterExceptionTest extends TestCase
{
    public function test()
    {
        $message = uniqid();
        $code = rand(PHP_INT_MIN, PHP_INT_MAX);

        $this->expectExceptionCode($code);
        $this->expectExceptionMessage($message);
        $this->expectException(RouterException::class);

        throw new RouterException($message, $code);
    }
}
