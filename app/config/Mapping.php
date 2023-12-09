<?php
/*
|--------------------------------------------------------------------------
| Route Mapping File
|--------------------------------------------------------------------------
|
| This file defines the mapping of routes based on HTTP methods (GET and POST).
|
| To add a new route, follow the structure below, specifying the URL segment
| as the key, and providing the 'handler' and 'middlewares' as needed.
|
| Example:
| 'example@custom' => [
|     'handler' => [CustomController::class, 'customMethod'],
|     'middlewares' => [CustomMiddleware::class, AnotherMiddleware::class]
| ]
|
| - 'GET' routes:
|   - 'example@call': An example route with an anonymous function as the handler.
|   - 'example@index': An example route invoking a controller method.
|   - 'example@middleware': An example route with middleware(s) applied.
|   - '@': Default route for the homepage.
|
| - 'POST' routes:
|   - 'example@post': An example route for handling POST requests.
|
| Handlers:
| - Anonymous function: 'handler' => function(){ /* code here * / },
| - Controller method: 'handler' => [ExampleController::class, 'index'],
|
| Middlewares:
| - Specify middleware class names as an array of strings.
|
*/

return [
    'GET' => [
        'example@call' => [
            'handler' => function () {
                echo 'Hello world';
            },
            'middlewares' => [],
        ],
        'example@index' => [
            'handler' => [ExampleController::class, 'index'],
            'middlewares' => [],
        ],
        'example@middleware' => [
            'handler' => function () {
                echo 'Middleware called!';
            },
            'middlewares' => [ExampleMiddleware::class],
        ],
        '@' => [
            'handler' => function () {
                echo 'this is the homepage.';
            },
            'middlewares' => [],
        ],
    ],
    'POST' => [
        'example@post' => [
            'handler' => function ($req) {
                var_dump($req);
            },
            'middlewares' => [],
        ],
    ],
];
