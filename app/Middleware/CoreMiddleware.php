<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Response\Constant\SystemCode;
use App\Response\ServerResponse;
use Hyperf\Contract\Arrayable;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\Di\Annotation\Inject;

class CoreMiddleware extends \Hyperf\HttpServer\CoreMiddleware {

    #[Inject] protected ServerResponse $response;

    /**
     * 路由找不到
     */
    protected function handleNotFound( ServerRequestInterface $request ): ResponseInterface {
        return $this->response->error( SystemCode::DOCUMENT_NOT_FOUND );
    }

    /**
     * 方法非公有
     */
    protected function handleMethodNotAllowed( array $methods, ServerRequestInterface $request ): ResponseInterface {
        return $this->response->error( SystemCode::DOCUMENT_NOT_FOUND );
    }
}
