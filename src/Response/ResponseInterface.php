<?php
namespace Router\Response;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function render();

    /**
     * @return int
     */
    public function getHttpCode();

    /**
     * @return array
     */
    public function getHeaders();
}
