<?php
declare(strict_types=1);
namespace Vertexbz\Router\Response;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function render(): string;

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return int
     */
    public function getCode(): int;

    /**
     * @return array
     */
    public function getHeaders(): array;
}
