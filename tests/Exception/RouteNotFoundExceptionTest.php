<?php
declare(strict_types=1);

namespace tests\Vertexbz\Router\Exception;


use PHPUnit\Framework\TestCase;
use Vertexbz\Router\Exception\RouteNotFoundException;

/**
 * @covers \Vertexbz\Router\Exception\RouteNotFoundException
 * @uses \Vertexbz\Router\Exception\RouterException
 */
class RouteNotFoundExceptionTest extends TestCase
{
    public function test()
    {
        $message = uniqid();

        $this->expectExceptionCode(404);
        $this->expectExceptionMessage($message);
        $this->expectException(RouteNotFoundException::class);

        throw new RouteNotFoundException($message);
    }
}
