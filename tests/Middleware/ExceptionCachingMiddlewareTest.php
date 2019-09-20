<?php
declare(strict_types=1);

namespace tests\Vertexbz\Router\Middleware;


use PHPUnit\Framework\TestCase;
use Vertexbz\Router\Exception\RouterException;
use Vertexbz\Router\Middleware\ExceptionCachingMiddleware;
use Vertexbz\Router\Request\RequestInterface;
use Vertexbz\Router\Response\ResponseInterface;
use Vertexbz\Router\Route\Invoker\MiddlewareInvoker;


/**
 * @covers \Vertexbz\Router\Middleware\ExceptionCachingMiddleware
 */
class ExceptionCachingMiddlewareTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ExceptionCachingMiddleware
     */
    protected $subject;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RequestInterface
     */
    protected $requestMock;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|MiddlewareInvoker
     */
    protected $invokerMock;
    /**
     * @var \PHPUnit_Framework_MockObject_Builder_InvocationMocker
     */
    protected $invokerMock__invoke;

    public function setUp()
    {
        $this->subject = new ExceptionCachingMiddleware();

        $this->requestMock = $this->getMockForAbstractClass(RequestInterface::class);

        $this->invokerMock = $this->getMockBuilder(MiddlewareInvoker::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $this->invokerMock__invoke = $this->invokerMock
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->requestMock);
    }

    /**
     * @uses \Vertexbz\Router\Response\BasicHttpResponse
     */
    public function testCachingException()
    {
        $this->invokerMock__invoke->willReturnCallback(function (){
            throw $this->getMockBuilder(\Exception::class)->getMock();
        });

        $response = $this->subject->process($this->requestMock, $this->invokerMock);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @uses \Vertexbz\Router\Response\BasicHttpResponse
     * @uses \Vertexbz\Router\Exception\RouterException
     */
    public function testCachingRouterException()
    {
        $this->invokerMock__invoke->willReturnCallback(function (){
            $mock = $this
                ->getMockBuilder(RouterException::class)
                ->setConstructorArgs(['Exception message', 418])
                //->setMethods(['getCode'])
                ->getMock();

            throw $mock;
        });

        $response = $this->subject->process($this->requestMock, $this->invokerMock);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(418, $response->getCode());

    }

    /**
     * @uses \Vertexbz\Router\Response\BasicHttpResponse
     */
    public function testCachingThrowable()
    {
        $this->invokerMock__invoke->willReturnCallback(function (){
            throw $this->getMockForAbstractClass(\Error::class);
        });

        $response = $this->subject->process($this->requestMock, $this->invokerMock);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testNoException()
    {
        $responseMock = $this->getMockForAbstractClass(ResponseInterface::class);
        $this->invokerMock__invoke->willReturn($responseMock);

        $response = $this->subject->process($this->requestMock, $this->invokerMock);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame($responseMock, $response);
    }
}
