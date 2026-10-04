<?php
declare( strict_types = 1 );
namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Response\ServerResponse;
use Hyperf\Contract\SessionInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * session鉴权
 */
class SessionAuthMiddleware implements MiddlewareInterface {
    /**
     * construct
     * @param SessionInterface $session session
     * @param ServerResponse $response server响应
     */
    public function __construct(
        private SessionInterface $session,
        private ServerResponse $response,
    ) {

    }

    /** handler */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        


        // next
        return $handler->handle( $request );
    }
}