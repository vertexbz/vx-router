<?php
declare(strict_types=1);

namespace tests\Vertexbz\Router\Request\Factory\Traits;


use PHPUnit\Framework\TestCase;
use Vertexbz\Router\Exception\RouterException;
use Vertexbz\Router\Request\Factory\Traits\UrlParamsExtractorTrait;
use Vertexbz\Router\Route\Route;

/**
 * Class UrlParamsExtractorTraitTest
 * @package tests\Vertexbz\Router\Request\Factory\Traits
 * @covers \Vertexbz\Router\Request\Factory\Traits\UrlParamsExtractorTrait
 */
class UrlParamsExtractorTraitTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UrlParamsExtractorTrait
     */
    protected $subject;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Route
     */
    protected $routeMock;
    /**
     * @var \ReflectionMethod
     */
    protected $extractRouteParamsReflection;

    public function setUp()
    {
        $this->subject = $this->getMockForTrait(UrlParamsExtractorTrait::class);

        $this->routeMock = $this->getMockBuilder(Route::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRegEx', 'getDefaultParams'])
            ->getMock();

        ($this->extractRouteParamsReflection = (new \ReflectionObject($this->subject))
            ->getMethod('extractRouteParams'))
            ->setAccessible(true);
    }

    public function routeDataProvider()
    {
        return [
            [
                '|^/part/(?P<var>\\d+)$|',
                '/part/123',
                [],
                ['var'=>'123']
            ],
            [
                '|^/part/(?P<var>\\d+)$|',
                '/part/123',
                ['foo' => 'bar'],
                ['var' => '123', 'foo' => 'bar']
            ],
            [
                '|^/part/(?P<var>\\d+)$|',
                '/part/123',
                ['var' => 'bar'],
                ['var' => '123']
            ],
            [
                '|^/part(:?/(?P<var>\\d+))?$|',
                '/part',
                ['var' => 'bar'],
                ['var' => 'bar']
            ],
            [
                '|^/part/(:?(?P<var>\\d+))?$|',
                '/part/',
                ['var' => 'bar'],
                ['var' => 'bar']
            ]
        ];
    }

    /**
     * @dataProvider routeDataProvider
     * @param $regex
     * @param $url
     * @param $defaultParams
     * @param $expectedResult
     */
    public function test($regex, $url, $defaultParams, $expectedResult)
    {
        $this->routeMock
            ->expects($this->once())
            ->method('getRegEx')
            ->willReturn($regex);

        $this->routeMock
            ->expects($this->once())
            ->method('getDefaultParams')
            ->willReturn($defaultParams);

        $params = $this->extractRouteParamsReflection->invoke($this->subject, $this->routeMock, $url);

        ksort($expectedResult);
        ksort($params);

        $this->assertSame($expectedResult, $params);
    }

    public function routeBadDataProvider()
    {
        return [
            [
                '|^/part/(?P<var>\\d+)$|',
                '/part/123/'
            ],
            [
                '|^/part/(?P<var>\\d+)$|',
                '/part/123.'
            ],
            [
                '|^/part/(?P<var>\\d+)$|',
                ''
            ],
            [
                '|^/part(:?/(?P<var>\\d+))?$|',
                '/part/'
            ],
            [
                '|^/part/(:?(?P<var>\\d+))?$|',
                '/part'
            ],
        ];
    }

    /**
     * @uses \Vertexbz\Router\Exception\RouterException
     * @dataProvider routeBadDataProvider
     * @param $regex
     * @param $url
     */
    public function testBadUrl($regex, $url)
    {
        $this->routeMock
            ->expects($this->once())
            ->method('getRegEx')
            ->willReturn($regex);

        $this->expectException(RouterException::class);
        $this->extractRouteParamsReflection->invoke($this->subject, $this->routeMock, $url);
    }
}
