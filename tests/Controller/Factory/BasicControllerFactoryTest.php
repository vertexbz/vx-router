<?php
declare(strict_types=1);
namespace tests\Vertexbz\Router\Controller\Factory;

use PHPUnit\Framework\TestCase;
use Vertexbz\Router\Controller\ControllerInterface;
use Vertexbz\Router\Controller\Factory\BasicControllerFactory;
use Vertexbz\Router\Route\Invoker\ControllerInvoker;
use Vertexbz\Router\Route\Route;

/**
 * @covers \Vertexbz\Router\Controller\Factory\BasicControllerFactory
 */
class BasicControllerFactoryTest extends TestCase
{
    /**
     * @var BasicControllerFactory
     */
    protected $subject;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Route
     */
    protected $routeMock;

    public function setUp()
    {
        $this->subject = new BasicControllerFactory();
        $this->routeMock = $this->getMockBuilder(Route::class)
            ->disableOriginalConstructor()
            ->setMethods(['getControllerClass'])
            ->getMock();
    }

    public function testWrongClass()
    {
        $this->routeMock->method('getControllerClass')->willReturn(\stdClass::class);
        $this->expectException(\TypeError::class);
        $this->subject->createController($this->routeMock);
    }

    public function testCorrectClass()
    {
        $controllerMock = $this->getMockForAbstractClass(ControllerInterface::class);
        $this->routeMock->method('getControllerClass')->willReturn(get_class($controllerMock));

        $factorizedController = $this->subject->createController($this->routeMock);
        $this->assertInstanceOf(ControllerInterface::class, $factorizedController);
    }
}
