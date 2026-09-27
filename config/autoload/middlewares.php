<?php

declare(strict_types=1);

use App\Middleware\AllowCorsDomainMiddleware;
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
        AllowCorsDomainMiddleware::class,
        TraceMiddleware::class,
    ],
];
