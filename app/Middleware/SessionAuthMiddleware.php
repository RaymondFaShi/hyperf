<?php
declare( strict_types = 1 );
namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\SessionInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as ContractResponseInterface;
use Hyperf\Redis\Redis;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * session鉴权
 */
class SessionAuthMiddleware implements MiddlewareInterface {
    /** sessionAuth配置信息 */
    private readonly array $sessionAuthConfig;

    /** 加密算法 */
    private string $algorithm = 'aes-256-gcm';

    /**
     * construct
     * @param SessionInterface $session session
     * @param ContractResponseInterface $response 响应
     */
    public function __construct(
        private SessionInterface $session,
        private ContractResponseInterface $response,
        private Redis $redis,
        ConfigInterface $config,
    ) {
        $this->sessionAuthConfig = $config->get( 'custom.sessionAuth' );
    }

    /** handler */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        // 获取当前用户id
        $userId = $this->session->get( 'userId' );

        // 查询是否存在记住登录的token
        $cookies = $request->getCookieParams(); // 全部cookie
        if( isset( $cookies[ 'remember_token' ] ) ) {    // 如果有记住登录token
            try {
                // 获取remeberToken
                $rememberToken = $cookies[ 'remember_token' ];

                // 解密数据
                $payload = aesDecrypt( $this->algorithm, $rememberToken, $this->sessionAuthConfig[ 'passphrase' ] );
                
                // 解码数据
                if( $payload = json_decode( $payload ) ) {
                    // 选择和验证
                    $selector = $payload->selector;
                    $validator = $payload->validator;

                    // 从redis拉取授权信息
                    $authKey = 'sessionAuth:remember:'. $selector;
                    $user = $this->redis->hGetAll( $authKey );

                    // 如果验证码和redis一致，恢复session
                    if( hash_equals( $validator, $user[ 'validator' ] ) ) {
                        $userId = $user[ 'userId' ];
                        $this->session->set( 'userId', $userId );
                    }
                    
                }
            }
            catch( \Throwable $ex ) {}
        }

        // 如果没有userId
        if( !$userId ) {
            // 重定向登录uri
            $redirectLoginUri = $this->sessionAuthConfig[ 'redirectLoginUri' ];

            return $this->response->redirect( $redirectLoginUri );
        }

        // next
        return $handler->handle( $request );
    }
}