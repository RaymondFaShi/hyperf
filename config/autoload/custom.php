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

        'passphrase' => env( 'API_AUTH_PASSPHRASE' ),   // 短语口令
    ],

    // session登录
    'sessionAuth' => [
        // 记住登录生命周期
        'rememberLifetime' => 7 * 24 * 60 * 60, // 记住登录，默认7天

        // 记住登录短语口令
        'passphrase' => env( 'SESSION_AUTH_REMEMBER_PASSPHRASE' ),   // 短语口令

        // 登录uri
        'redirectLoginUri' => '/user/login',    // 重定向登录地址
    ]
];