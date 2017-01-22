<?php
declare(strict_types=1);
namespace Router;

class Route
{
    const METHODS = 'methods';
    const REGEX = 'regex';
    const NAMES = 'names';
    const CONTROLLER = 'controller';
    const ACTION = 'action';
    const PARAM_NAMES = 'param-names';
    const REQUEST_CLASS =  'request-class';
    const RESPONSE_CLASS =  'response-class';

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
        return $this->routeData[self::ACTION];
    }

    /**
     * @return string
     */
    public function getControllerClass(): string
    {
        return $this->routeData[self::CONTROLLER];
    }

    /**
     * @return string
     */
    public function getRegEx(): string
    {
        return $this->routeData[self::REGEX];
    }

    /**
     * @return array
     */
    public function getParamNames(): array
    {
        return (array)($this->routeData[self::PARAM_NAMES] ?? []);
    }

    /**
     * @return string
     */
    public function getRequestClass(): ?string
    {
        return $this->routeData[self::REQUEST_CLASS] ?? null;
    }

    /**
     * @return array
     */
    public function getRequestMethods(): array
    {
        return (array)($this->routeData[self::METHODS] ?? []);
    }

    /**
     * @return string
     */
    public function getResponseClass(): ?string
    {
        return $this->routeData[self::RESPONSE_CLASS] ?? null;
    }
}
