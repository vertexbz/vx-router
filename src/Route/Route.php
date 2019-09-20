<?php
declare(strict_types=1);
namespace Vertexbz\Router\Route;

class Route
{
    const METHODS = 'methods';
    const REGEX = 'regex';
    const NAMES = 'names';
    const MIDDLEWARES = 'middlewares';
    const CONTROLLER = 'controller';
    const ACTION = 'action';
    const REQUEST_CLASS =  'request-class';
    const RESPONSE_CLASS =  'response-class';
    const DEFAULT_PARAMS = 'default-params';

    /**
     * @var array
     */
    protected $routeData;

    /**
     * Route constructor.
     * @param array $routeData
     */
    public function __construct(array $routeData)
    {
        $this->routeData = $routeData;
    }

    /**
     * @return string
     */
    public function getControllerAction(): string
    {
        return (string)$this->routeData[self::ACTION];
    }

    /**
     * @return string
     */
    public function getControllerClass(): string
    {
        return (string)$this->routeData[self::CONTROLLER];
    }

    /**
     * @return string
     */
    public function getRegEx(): string
    {
        return (string)$this->routeData[self::REGEX];
    }

    /**
     * @return string
     */
    public function getRequestClass(): ?string
    {
        return (string)$this->routeData[self::REQUEST_CLASS];
    }

    /**
     * @return array
     */
    public function getRequestMethods(): array
    {
        return (array)($this->routeData[self::METHODS] ?? []);
    }

    /**
     * @return string|null
     */
    public function getResponseClass(): ?string
    {
        if (isset($this->routeData[self::RESPONSE_CLASS])) {
            return (string)$this->routeData[self::RESPONSE_CLASS];
        }
        return null;
    }

    /**
     * @return string[]
     */
    public function getMiddlewares(): array
    {
        return (array)($this->routeData[self::MIDDLEWARES] ?? []);
    }

    /**
     * @return string[]
     */
    public function getDefaultParams()
    {
        return (array)($this->routeData[self::DEFAULT_PARAMS] ?? []);
    }
}
