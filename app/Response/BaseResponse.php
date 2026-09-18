<?php
declare( strict_types = 1 );
namespace App\Response;

use App\Response\Constant\SystemCode;
use App\Response\Interfaces\ResponseStruct;
use App\Response\Interfaces\ResultStruct;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Override;

abstract class BaseResponse implements ResponseStruct {

    /**
     * 系统代码消息映射
     */
    public const SYSTEM_CODE_MESSAGE = [
        SystemCode::DOCUMENT_NOT_FOUND      => 'document not found',
        SystemCode::INTERNAL_SERVER_ERROR   => 'internal server error',
        SystemCode::INVALID_DATA            => 'invalid data',
        SystemCode::PERMISSION_DENIED       => 'permission denied',
    ];

    /**
     * header报头信息
     */
    public array $headers = [
        'server' => 'alpha',    // 遮盖服务
        'Content-Type' => 'application/json',   // 返回json格式
    ];

    /**
     * 返回http状态
     */
    public int $httpStatus = 200;

    /**
     * 响应
     */
    #[Inject] public ResponseInterface $response;

    /**
     * 成功
     */
    #[Override] public function success( int|string $code, ?ResultStruct $result ): ResponseInterface {
        // 系统代码消息
        $systemCodeMessage = static::SYSTEM_CODE_MESSAGE[ $code ];

        // 初始化返回数据
        $responseData = [ 'code' => $code, 'message' => $systemCodeMessage ];
        if( $result ) $responseData[ 'result' ] = $result;

        // 响应
        return $this->json( $responseData );
    }

    /**
     * 失败
     */
    #[Override] public function error( int|string $code ): ResponseInterface {
        // 系统代码消息
        $systemCodeMessage = static::SYSTEM_CODE_MESSAGE[ $code ];

        // 初始化返回数据
        $responseData = [ 'code' => $code, 'message' => $systemCodeMessage ];

        // 响应
        return $this->json( $responseData );
    }

    /**
     * 返回json数据
     */
    private function json( array $data ): ResponseInterface {
        // header
        foreach( $this->headers as $headerName => $headerValue ) $this->response->withHeader( $headerName, $headerValue );

        // http status
        $this->response->withStatus( $this->httpStatus );

        // body
        $bodyStream = new SwooleStream( json_encode( $data, JSON_UNESCAPED_UNICODE ) );
        $this->response->withBody( $bodyStream );

        return $this->response;
    }
}