<?php
declare( strict_types = 1 );
namespace App\Middleware;

use App\Response\Constant\SystemCode;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Response\ServerResponse;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Redis\Redis;

/**
 * jwt鉴权
 */
class JwtAuthMiddleware implements MiddlewareInterface {
    /** jwt配置信息 */
    private readonly array $jwtConfig;

    /**
     * construct
     * @param ServerResponse $response server响应
     */
    public function __construct(
        private ServerResponse $response,
        private Redis $redis,
        ConfigInterface $config,
    ) {
        $this->jwtConfig = $config->get( 'jwt', [] );
    }

    /** handler */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        // 获取报头beartToken
        $authorization = substr( $request->getHeaderLine( 'Authorization' ), 7 );
        if( !$authorization ) $this->response->error( SystemCode::NO_LOGIN );

        // 验证token
        try {
            // 生成密钥key
            $secretKey = new Key( $this->jwtConfig[ 'secret' ], $this->jwtConfig[ 'alg' ] );

            // 解密jwt
            $payload = JWT::decode( $authorization, $secretKey );

            // 获取已经登录的session
            $sessionId = $payload->jti;


        }

        catch ( \Throwable $ex ) {
            return $this->response->error( SystemCode::NO_LOGIN );
        }

        // next
        return $handler->handle( $request );
    }
}