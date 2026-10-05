<?php

declare(strict_types=1);

use App\Middleware\AllowCorsDomainMiddleware;
use App\Middleware\CsrfTokenMiddleware;
use App\Middleware\JwtAuthMiddleware;
use App\Middleware\TraceMiddleware;

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'http' => [
        \Hyperf\Session\Middleware\SessionMiddleware::class,

        AllowCorsDomainMiddleware::class,
        TraceMiddleware::class,
        // CsrfTokenMiddleware::class,
    ],
];
