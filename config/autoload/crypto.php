<?php
declare( strict_types = 1 );

use function Hyperf\Support\env;

return [
    'algorithms' => [
        'aes-256-gcm' => [
            'ivLength' => 12,
            'tagLength' => 16,
            'passphraseLength' => 32,
        ],

        'aes-256-cbc' => [
            'ivLength' => 16,
            'tagLength' => 0,
            'passphraseLength' => 32,
        ],
    ]
];