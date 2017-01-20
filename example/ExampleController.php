<?php
declare(strict_types = 1);

use Router\Controller\ControllerInterface;
use Router\Request\BasicHttpRequest;
use Router\Response\BasicHttpResponse;

class ExampleController implements ControllerInterface
{

    /**
     * @route /
     * @param BasicHttpRequest $request
     * @param BasicHttpResponse $response
     */
    public function exampleAction(BasicHttpRequest $request, BasicHttpResponse $response)
    {
        $response->setBody('Hello World!');
    }
}
