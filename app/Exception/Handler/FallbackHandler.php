<?php
declare( strict_types = 1 );
namespace App\Exception\Handler;

use App\Response\Constant\SystemCode;
use App\Response\ServerResponse;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class FallbackHandler extends ExceptionHandler {

    /**
     * construct
     */
    public function __construct( 
        protected StdoutLoggerInterface $console,
        protected LoggerInterface $logger,
        protected ServerResponse $response 
    ) {

    }

    /**
     * 兜底ex
     */
    public function handle( Throwable $throwable, ResponseInterface $response ) {
        // 阻止冒泡
        $this->stopPropagation();

        // 控制台信息
        $this->console->error( sprintf( '[ Code:%s ] [ Message:%s ] [ File:%s ] [ Line:%s ] [ Ex:%s ]', $throwable->getCode(), $throwable->getMessage(), $throwable->getLine(), $throwable->getFile(), $throwable::class ) );
        $this->console->error( $throwable->getTraceAsString() );

        // 记录日志
        $this->logger->error( sprintf( 
            '[%s] %s[%s, %s]',
            $throwable->getMessage(),
            $throwable->getFile(),
            $throwable->getCode(),
            $throwable->getLine(), 
            
        ) );

        // 响应数据
        return $this->response->error( SystemCode::INTERNAL_SERVER_ERROR );
    }

    /**
     * 验证
     */
    public function isValid( Throwable $throwable ): bool {
        return true;
    }
}