<?php
declare( strict_types = 1 );

use function Hyperf\Support\env;

return [
    // 密钥
    'secret' => env( 'JWT_SECRET' ),

    // 签发人
    'iss' => env( 'APP_URL' ),

    // 接收人
    'aud' => '',

    // 加密方式
    'alg' => 'HS256'
];