<?php
declare( strict_types = 1 );
namespace App\Middleware;

use App\Response\Constant\SystemCode;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Response\ServerResponse;
use Hyperf\Contract\SessionInterface;
use Hyperf\Redis\Redis;
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
        private Redis $redis,
    ) {

    }

    /** handler */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        // 获取当前用户id
        $userId = $this->session->get( 'userId' );

        // 查询是否存在记住登录的token
        $cookies = $request->getCookieParams(); // 全部cookie
        if( isset( $cookies[ 'rememberToken' ] ) ) {    // 如果有记住登录token
            $rememberToken = $cookies[ 'rememberToken' ];

            // 从redis拉取授权信息
            $authKey = 'sessionAuth:remember:'. $rememberToken;
            $userId = $this->redis->hGetAll( $authKey );

            // 恢复session
            $this->session->set( 'userId', $userId );
        }

        // 如果没有userId
        if( !$userId ) {
            return $this->response->error( SystemCode::NO_LOGIN );
        }

        // next
        return $handler->handle( $request );
    }
}