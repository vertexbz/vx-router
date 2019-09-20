<?php
declare(strict_types=1);

namespace tests\Vertexbz\Router\Exception;


use PHPUnit\Framework\TestCase;
use Vertexbz\Router\Exception\BadRequestMethodException;

/**
 * @covers \Vertexbz\Router\Exception\BadRequestMethodException
 * @uses \Vertexbz\Router\Exception\RouterException
 */
class BadRequestMethodExceptionTest extends TestCase
{
    public function test()
    {
        $message = uniqid();

        $this->expectExceptionCode(400);
        $this->expectExceptionMessage($message);
        $this->expectException(BadRequestMethodException::class);

        throw new BadRequestMethodException($message);
    }
}
