<?php
declare( strict_types = 1 );
namespace App\Exception\Handler;

use App\Response\Constant\SystemCode;
use App\Response\ServerResponse;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class FallbackHandler extends ExceptionHandler {

    /**
     * construct
     */
    public function __construct( protected StdoutLoggerInterface $logger, protected ServerResponse $response ) {

    }

    /**
     * 兜底ex
     */
    public function handle( Throwable $throwable, ResponseInterface $response ) {
        // 阻止冒泡
        $this->stopPropagation();

        // 控制台信息
        $this->logger->error( sprintf( '%s[%s] in %s', $throwable->getCode(), $throwable->getMessage(), $throwable->getLine(), $throwable->getFile() ) );
        $this->logger->error( $throwable->getTraceAsString() );

        // 响应数据
        return $this->response->error( SystemCode::DOCUMENT_NOT_FOUND );
    }

    /**
     * 验证
     */
    public function isValid( Throwable $throwable ): bool {
        return true;
    }
}