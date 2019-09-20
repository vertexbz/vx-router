<?php
declare(strict_types = 1);
namespace Vertexbz\Router\Response;

class BasicHttpResponse implements ResponseInterface
{
    /**
     * @var string
     */
    protected $body = '';

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var int
     */
    protected $responseCode = 200;

    /**
     * @param string $body
     * @return BasicHttpResponse
     */
    public function setBody(string $body): BasicHttpResponse
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param int $responseCode
     * @return BasicHttpResponse
     */
    public function setResponseCode(int $responseCode): BasicHttpResponse
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     * @param string $headerName
     * @param string $value
     * @return BasicHttpResponse
     */
    public function addHeader(string $headerName, string $value): BasicHttpResponse
    {
        $header = &$this->headers[$headerName];

        if (!empty($header)) {
            if (!is_array($header)) {
                $header = [$header];
            }
            $header[] = $value;
        } else {
            $header = $value;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->responseCode;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->body;
    }
}
