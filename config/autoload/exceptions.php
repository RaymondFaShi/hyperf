<?php

declare(strict_types=1);

// 系统ex
use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;

// 自定义ex
use App\Exception\Handler\FallbackHandler;

return [
    'handler' => [
        'http' => [
            FallbackHandler::class,
        ],
    ],
];
