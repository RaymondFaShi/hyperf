<?php

declare(strict_types=1);

use App\Annotation\Collector\ValidatorCollector;

return [
    'scan' => [
        'paths' => [
            BASE_PATH . '/app/Annotation',
        ],
        'collectors' => [
            // ValidatorCollector::class
        ],
        'ignore_annotations' => [
            'mixin',
        ],
    ],
];
