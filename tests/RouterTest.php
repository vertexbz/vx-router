<?php
declare(strict_types=1);
namespace tests\Vertexbz\Router;


use PHPUnit\Framework\TestCase;
use Vertexbz\Router\Request\Factory\RequestFactoryInterface;
use Vertexbz\Router\Response\ResponseInterface;
use Vertexbz\Router\Route\Invoker\RouteInvokerInterface;
use Vertexbz\Router\Router;
use Vertexbz\Router\RouteResolver\RouteResolverInterface;

/**
 * Class RouterTest
 * @package tests\Vertexbz\Router
 * @covers \Vertexbz\Router\Router
 */
class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    protected $subject;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RouteResolverInterface
     */
    protected $resolver;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RouteInvokerInterface
     */
    protected $invoker;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RequestFactoryInterface
     */
    protected $requestFactory;

    public function setUp()
    {
        $this->resolver = $this->getMockForAbstractClass(RouteResolverInterface::class);
        $this->invoker = $this->getMockForAbstractClass(RouteInvokerInterface::class);
        $this->requestFactory = $this->getMockForAbstractClass(RequestFactoryInterface::class);

        $this->subject = new Router($this->resolver, $this->requestFactory, $this->invoker);
    }

    /**
     * @runInSeparateProcess
     */
    public function testRun()
    {
        $response = $this->getMockForAbstractClass(ResponseInterface::class);

        $responseCode = 400;
        $response->method('getCode')->willReturn($responseCode);

        $responseBody = uniqid();
        $response->method('render')->willReturn($responseBody);


        $responseHeaders = [
            'Set-cookie' => 'asd=123'
        ];
        $response->method('getHeaders')->willReturn($responseHeaders);

        $this->invoker->method('invoke')->willReturn($response);

        $this->expectOutputString($responseBody);
        $this->subject->run();

        $this->assertSame($responseCode, http_response_code());
        $this->assertArraySubset(['Set-cookie: asd=123'], xdebug_get_headers());
    }
}
