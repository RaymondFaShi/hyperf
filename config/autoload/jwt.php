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
    'alg' => 'HS256',

    // 生命周期
    'lifetime' => 7 * 24 * 60 * 60, // 默认7天，0为不限制
];