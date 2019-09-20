<?php
declare(strict_types=1);

namespace tests\Vertexbz\Router\Exception;


use PHPUnit\Framework\TestCase;
use Vertexbz\Router\Exception\InvalidMiddlewareException;

/**
 * @covers \Vertexbz\Router\Exception\InvalidMiddlewareException
 * @uses \Vertexbz\Router\Exception\RouterException
 */
class InvalidMiddlewareExceptionTest extends TestCase
{

    public function test()
    {
        $message = uniqid();

        $this->expectExceptionCode(500);
        $this->expectExceptionMessage($message);
        $this->expectException(InvalidMiddlewareException::class);

        throw new InvalidMiddlewareException($message);
    }
}
