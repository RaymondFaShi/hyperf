<?php
declare( strict_types = 1 );
namespace App\Middleware;

use App\Response\Constant\SystemCode;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Response\ServerResponse;
use Hyperf\Context\Context;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Redis\Redis;
use Libaray\Crypto;

/**
 * api鉴权
 */
class AuthenticateMiddleware implements MiddlewareInterface {
    /** crypto配置信息 */
    private readonly array $cryptoConfig;

    /** 加密算法 */
    private string $algorithm = 'aes-256-gcm';

    /**
     * construct
     * @param ServerResponse $response server响应
     */
    public function __construct(
        private ServerResponse $response,
        private Redis $redis,
        ConfigInterface $config,
    ) {
        $this->cryptoConfig = $config->get( 'crypto' );
    }

    /** handler */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        // 获取报头bearToken
        $authorization = substr( $request->getHeaderLine( 'Authorization' ), 7 );
        if( !$authorization ) return $this->response->error( SystemCode::NO_LOGIN );

        // 初始化加密类
        $algorithmsConfig = $this->cryptoConfig[ $this->algorithm ];    // 加密算法配置
        $passphrase = base64_decode( $this->cryptoConfig[ 'passphrase' ], true );   // 短语口令
        $crypto = new Crypto( $this->algorithm, $algorithmsConfig[ 'ivLength' ], $algorithmsConfig[ 'tagLength' ], $algorithmsConfig[ 'passphraseLength' ] );

        // 解密bearToken
        try {
            // bearToken
            $bearToken = $crypto->decrypt( $authorization, $passphrase );

            // 解码数据
            $payload = json_decode( $bearToken );
            
            // 获取数据
            $sessionId = $payload->sessionId;   // session id
            $loginTime = $payload->loginTime;   // 该token登录时间节点

            // 从redis拉取授权信息
            $authKey = 'apiAuth:user:'. $sessionId;
            $user = $this->redis->hGetAll( $authKey );
            
            // 如果没有用户登录信息说明登录失效
            if( !$user ) {
                return $this->response->error( SystemCode::NO_LOGIN );
            }

            // 单点登录
            // if( !$loginTime || !$user[ 'loginTime' ] || ( strtotime( $loginTime ) < strtotime( $user[ 'loginTime' ] ) ) ) {
            //     return $this->response->error( SystemCode::NO_LOGIN );
            // }

            // userId加入到上下文
            Context::set( 'userId', $user[ 'userId' ] );
        }
        catch( \Throwable $ex ) {
            return $this->response->error( SystemCode::NO_LOGIN );
        }


        // next
        return $handler->handle( $request );
    }
}