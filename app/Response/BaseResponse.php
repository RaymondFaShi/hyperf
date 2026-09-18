<?php
declare( strict_types = 1 );
namespace App\Response;

use App\Response\Constant\SystemCode;
use App\Response\Interfaces\ResponseInterface as InterfacesResponseInterface;
use App\Response\Interfaces\ResultInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as MessageResponseInterface;
use Override;


abstract class BaseResponse implements InterfacesResponseInterface {

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
    private array $forceHeaders = [ // 强制报头
        'server' => 'alpha',    // 遮盖服务
        'Content-Type' => 'application/json',   // 返回json格式
    ];

    public array $headers = [];

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
    #[Override] public function success( int|string $code, ?ResultInterface $result ): MessageResponseInterface {
        // 系统代码消息
        $systemCodeMessage = static::SYSTEM_CODE_MESSAGE[ $code ];

        // 初始化返回数据
        $responseData = [ 'code' => $code, 'message' => $systemCodeMessage ];
        if( $result ) $responseData[ 'result' ] = $result->ok();

        // 响应
        return $this->json( $responseData );
    }

    /**
     * 失败
     */
    #[Override] public function error( int|string $code, ?ResultInterface $result = null ): MessageResponseInterface {
        // 系统代码消息
        $systemCodeMessage = static::SYSTEM_CODE_MESSAGE[ $code ];

        // 初始化返回数据
        $responseData = [ 'code' => $code, 'message' => $systemCodeMessage ];
        if( $result ) $responseData[ 'result' ] = $result->fail();

        // 响应
        return $this->json( $responseData );
    }

    /**
     * 返回json数据
     */
    private function json( array $data ): MessageResponseInterface {
        // 创建响应
        $response = $this->response;

        // header
        $headers = array_merge( $this->headers, $this->forceHeaders );
        foreach( $headers as $headerName => $headerValue ) $response = $response->withHeader( $headerName, $headerValue );

        // http status
        $response = $response->withStatus( $this->httpStatus );

        // body
        $bodyStream = new SwooleStream( json_encode( $data, JSON_UNESCAPED_UNICODE ) );
        $response = $response->withBody( $bodyStream );

        return $response;
    }
}