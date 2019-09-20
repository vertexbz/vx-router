<?php
declare(strict_types = 1);
namespace Vertexbz\Router\Request;

class BasicHttpRequest implements RequestInterface
{
    /**
     * @var array
     */
    protected $get;
    /**
     * @var array
     */
    protected $post;
    /**
     * @var array
     */
    protected $cookie;
    /**
     * @var array
     */
    protected $server;
    /**
     * @var array
     */
    protected $headers;
    /**
     * @var array
     */
    protected $params;

    /**
     * BasicRequest constructor.
     */
    protected function __construct()
    {
    }

    /**
     * @param string $name
     * @return string
     */
    public function getCookie(string $name): ?string
    {
        if (isset($this->cookie[$name])) {
            return (string)$this->cookie[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getCookieArray(): array
    {
        return $this->cookie;
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getGet(string $name): ?string
    {
        if (isset($this->get[$name])) {
            return (string)$this->get[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getGetArray(): array
    {
        return $this->get;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getHeader(string $name): ?string
    {
        if (isset($this->headers[$name])) {
            return (string)$this->headers[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getHeaderArray(): array
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getParam(string $name): ?string
    {
        if (isset($this->params[$name])) {
            return (string)$this->params[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getParamArray(): array
    {
        return $this->params;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getPost(string $name): ?string
    {
        if (isset($this->post[$name])) {
            return (string)$this->post[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getPostArray(): array
    {
        return $this->post;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getServerVar(string $name): ?string
    {
        if (isset($this->server[$name])) {
            return (string)$this->server[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getServerVarArray(): array
    {
        return $this->server;
    }
}
