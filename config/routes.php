<?php
declare( strict_types = 1 );    // 严格模式

use Hyperf\HttpServer\Router\Router;

// default
Router::get( '/', function () {
    // tests
    return [ 'code' => 0, 'message' => 'success', 'timestamp' => time() ];
});

/**
 * web路由
 */
Router::addGroup( '/v1', function() {
    // 用户user
    Router::addGroup( '/user', function () {
        Router::get( '', [ \App\Controller\User\Index::class, 'index' ] );
    } );

}, [ 'middleware' => [] ] );