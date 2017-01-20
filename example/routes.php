<?php

return [
    [
        'methods' => ['GET'],
        'regex' => '|^/$|',
        'names' => ['root'],
        'controller' => ExampleController::class,
        'action' => 'exampleAction',
    ]
];
