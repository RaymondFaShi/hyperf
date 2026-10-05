<?php
declare( strict_types = 1 );

use function Hyperf\Support\env;

return [
    // 允许跨域域名列表
    'allowDomain' => [
        'http://localhost:9527',
    ],

    // 允许排除在csrf token的资源列表
    'allowCsrfTokenExceptUri' => [
        
    ],

    // api登录
    'apiAuth' => [
        // 生命周期
        'lifetime' => 7 * 24 * 60 * 60, // 默认7天，0为不限制
    ]
];