<?php

return [
    [
        'methods' => ['GET'],
        'regex' => '|^/$|',
        'names' => ['root'],
        'controller' => ExampleController::class,
        'action' => 'exampleAction'
    ],
    [
        'methods' => ['GET'],
        'regex' => '|^/middleware$|',
        'names' => ['root'],
        'controller' => ExampleController::class,
        'action' => 'middlewareAction',
    ]
];
