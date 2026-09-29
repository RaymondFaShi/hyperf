<?php
declare(strict_types=1);
namespace App\Middleware;

use Hyperf\Context\Context;
use Hyperf\Contract\ConfigInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 跨域请求支持
 */
class AllowCorsDomainMiddleware implements MiddlewareInterface {
    /**
     * 允许域名列表
     */
    protected readonly array $allowDomain;

    /**
     * 输出报头
     */
    protected array $headers = [
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Max-Age'           => 1800,
        'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'     => 'Origin, Accept, Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With',
    ];

    public function __construct( ConfigInterface $config ) {
        $this->allowDomain = $config->get( 'custom.allowDomain' );
    }

    /**
     * 处理
     */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        // 如果是options请求，直接返回reposne
        if( $request->getMethod() === 'OPTIONS' ) {
            // 获取上下文response
            $response = Context::get( ResponseInterface::class );

            // 设置报头
            foreach( $this->headers as $headerName => $headerValue ) $response = $response->withHeader( $headerName, $headerValue );

            // 设置允许的domain
            $origin = $request->getHeaderLine( 'Origin' ); // 当前来源
            if( $origin && in_array( $origin, $this->allowDomain, true ) ) {
                $response = $response->withHeader( 'Access-Control-Allow-Origin', $origin );
                $response = $response->withHeader( 'Access-Control-Allow-Credentials', 'true' );
            }

            // 设置上下文的response
            Context::set( ResponseInterface::class, $response );
        
            return $response;
        }

        // next
        return $handler->handle( $request );
    }
}