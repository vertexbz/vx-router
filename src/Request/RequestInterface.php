<?php
declare(strict_types=1);
namespace Router\Request;

interface RequestInterface
{
    /**
     * BasicRequest constructor.
     * @param array $get
     * @param array $post
     * @param array $cookie
     * @param array $server
     * @param array $headers
     * @param array $params
     */
    public function __construct(array $get, array $post, array $cookie, array $server, array $headers, array $params);
}
