<?php
declare(strict_types=1);
namespace Router\Response;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function render(): string;

    /**
     * @return int
     */
    public function getHttpCode(): int;

    /**
     * @return array
     */
    public function getHeaders(): array;
}
