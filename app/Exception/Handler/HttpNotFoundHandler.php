<?php
declare( strict_types = 1 );
namespace App\Exception\Handler;

use App\Response\Constant\SystemCode;
use App\Response\ServerResponse;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpNotFoundHandler extends ExceptionHandler {

    /**
     * construct
     */
    public function __construct( protected StdoutLoggerInterface $console, protected ServerResponse $response ) {

    }

    /**
     * http路由找不到
     */
    public function handle( Throwable $throwable, ResponseInterface $response ) {
        // 阻止冒泡
        $this->stopPropagation();

        // 控制台信息
        // $this->console->error( sprintf( '[ Code:%s ] [ Message:%s ] [ File:%s ] [ Line:%s ] [ Ex:%s ]', $throwable->getCode(), $throwable->getMessage(), $throwable->getLine(), $throwable->getFile(), $throwable::class ) );
        // $this->console->error( $throwable->getTraceAsString() );

        // 响应数据
        return $this->response->error( SystemCode::DOCUMENT_NOT_FOUND );
    }

    /**
     * 验证
     */
    public function isValid( Throwable $throwable ): bool {
        return $throwable instanceof NotFoundHttpException;
    }
}