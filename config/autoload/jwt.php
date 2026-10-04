<?php
declare( strict_types = 1 );

use function Hyperf\Support\env;

return [
    // 密钥
    'secret' => env( 'JWT_SECRET' ),
];