<?php
declare(strict_types=1);

namespace tests\Vertexbz\Router\Middleware\Factory;

use PHPUnit\Framework\TestCase;
use Vertexbz\Router\Middleware\Factory\MiddlewareFactory;
use Vertexbz\Router\Middleware\MiddlewareInterface;

/**
 * @covers \Vertexbz\Router\Middleware\Factory\MiddlewareFactory
 */
class MiddlewareFactoryTest extends TestCase
{
    /**
     * @var MiddlewareFactory
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new MiddlewareFactory();
    }

    public function testWrongClass()
    {
        $this->expectException(\TypeError::class);
        $this->subject->createMiddleware(\stdClass::class);
    }

    public function testCorrectClass()
    {
        $middlewareMock = $this->getMockForAbstractClass(MiddlewareInterface::class);
        $factorizedMiddleware = $this->subject->createMiddleware(get_class($middlewareMock));
        $this->assertInstanceOf(MiddlewareInterface::class, $factorizedMiddleware);
    }
}
