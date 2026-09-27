<?php
declare( strict_types = 1 );
namespace App\Middleware;

use Hyperf\Context\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

/**
 * 链路追踪
 */
class TraceMiddleware implements MiddlewareInterface {

    /** traceId key */
    public const string TRACE_ID_KEY = 'traceId';

    /** requestId key */
    public const string REQUEST_ID_KEY = 'requestId';

    /** requestId 报头key */
    public const string REQUEST_ID_HEAD_KEY = 'x-request-id';
    
    /** handler */
    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        # trace
        $traceId = Uuid::uuid4()->toString();   // 生成traceId
        Context::set( self::TRACE_ID_KEY, $traceId );   // 加入上下文

        # request
        $requestId = $request->getHeaderLine( self::REQUEST_ID_HEAD_KEY )?? Uuid::uuid4()->toString();  // 获取/生成requestId
        Context::set( self::REQUEST_ID_KEY, $requestId );   // 加入上下文

        // 响应
        $response = $handler->handle( $request );
        $response = $response->withHeader( self::REQUEST_ID_HEAD_KEY, $requestId ); // 报头
        
        // next
        return $response;
    }
}