<?php
declare( strict_types = 1 );
namespace App\Middleware;

use App\Response\Constant\SystemCode;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Response\ServerResponse;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpMessage\Cookie\Cookie;

/**
 * jwt鉴权
 */
class CsrfTokenMiddleware implements MiddlewareInterface {

    /** 排除验证方法 */
    private array $exceptMethods = [ 'GET', 'HEAD', 'OPTIONS' ];

    /** 排除地址 */
    protected readonly array $exceptUri;

    /** 报头csrfToken name */
    public const CSRFTOKEN_NAME = 'x-csrf-token';

    /**
     * construct
     * @param ServerResponse $response server响应
     */
    public function __construct(
        private ServerResponse $response,
        // private SessionInterface $session,
        ConfigInterface $config,
    ) {
        $this->exceptUri = $config->get( 'allowCsrfTokenExceptUri', [
            '/v1/user'
        ] );
    }

    /** handler */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        // 初始化响应
        $response = $handler->handle( $request );

        // 获取当前cookies
        $cookies = $request->getCookieParams();

        // 如果在排除验证的方法里
        if( in_array( $request->getMethod(), $this->exceptMethods ) ){
            // 如果没有csrfToken的cookie
            if( !isset( $cookies[ self::CSRFTOKEN_NAME ] ) ) {
                // 查找session中的csrf_token
                // $csrfToken = $this->session->get( 'csrf_token' );

                // 生成csrfToken
                // if( !$csrfToken ) $csrfToken = generateUID();
                $csrfToken = generateUID();

                // 设置cookie
                $cookie = new Cookie( self::CSRFTOKEN_NAME, $csrfToken );
                $response = $response->withAddedHeader( 'Set-Cookie', ( string )$cookie );
            }
        }
    
        // 如何在不在排除验证的方法里
        else {
            // 当前url
            $uri = ( string ) $request->getUri();

            // 如果没有在排除地址名单里
            if( !$this->isExceptUri( $uri ) ) {
                $cookieCsrfToken = $cookies[ self::CSRFTOKEN_NAME ]?? null;
                $headerCsrfToken = $request->getHeaderLine( self::CSRFTOKEN_NAME );

                // 如果没有csrfToken或者header和cookie值不等
                if( !$cookieCsrfToken || !$headerCsrfToken || !hash_equals( $cookieCsrfToken, $headerCsrfToken ) ) {
                    return $this->response->error( SystemCode::CSRFTOKEN_MISMATCH );
                }
            }
        }
        return $response;
    }

    /**
     * 是否在排除资源里
     */
    private function isExceptUri( string $uri ): bool {
        // 循环匹配
        foreach( $this->exceptUri as $pattern ) {
            // 直接匹配上
            if( $pattern === $uri ) return true;

            // 如果当前规则有通配符
            if( str_ends_with( $pattern, '*' ) ) {
                $pattern = rtrim( $pattern, '*' );

                if( str_starts_with( $uri, $pattern ) ) {
                    return true;
                }
            }
        }

        return false;
    }
}