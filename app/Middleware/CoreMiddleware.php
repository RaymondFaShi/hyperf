<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Response\Constant\SystemCode;
use App\Response\ServerResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\Di\Annotation\Inject;
use Override;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 重构核心中间件
 */
class CoreMiddleware extends \Hyperf\HttpServer\CoreMiddleware {
    /**
     * construct
     */
    public function __construct( ContainerInterface $container, string $serverName, protected ServerResponse $response ) {
        return parent::__construct( $container, $serverName );
    }

    /** handler处理器 */
    #[Override] public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface {
        // 获取响应
        $response = parent::process( $request, $handler);

        // 修改server报头
        $response = $response->withoutHeader( 'Server' );
        $response = $response->withHeader( 'Server', 'alpha' );

        // 响应
        return $response;
    }

    /**
     * 路由找不到
     */
    #[Override] protected function handleNotFound( ServerRequestInterface $request ): ResponseInterface {
        // 响应
        return $this->response->error( SystemCode::DOCUMENT_NOT_FOUND );
    }

    /**
     * 方法非公有
     */
    #[Override] protected function handleMethodNotAllowed( array $methods, ServerRequestInterface $request ): ResponseInterface {
        // 响应
        return $this->response->error( SystemCode::DOCUMENT_NOT_FOUND );
    }
}
