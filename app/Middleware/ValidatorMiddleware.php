<?php
declare( strict_types = 1 );
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 链路追踪
 */
class ValidatorMiddleware implements MiddlewareInterface {

    /** handler */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        // devLog( $request );

        // 响应
        $response = $handler->handle( $request );
        
        // next
        return $response;
    }
}