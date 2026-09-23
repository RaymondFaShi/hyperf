<?php

declare(strict_types=1);

// 系统ex
use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;

// 自定义ex
use App\Exception\Handler\FallbackHandler;
use App\Exception\Handler\HttpNotFoundHandler;

return [
    'handler' => [
        'http' => [
            HttpNotFoundHandler::class,
            FallbackHandler::class,
        ],
    ],
];
