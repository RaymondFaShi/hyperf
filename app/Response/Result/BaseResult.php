<?php
declare( strict_types = 1 );
namespace App\Response\Result;

use App\Response\Interfaces\ResultInterface;
use Override;

abstract class BaseResult implements ResultInterface {
    /**
     * status 状态
     */
    public int|string $status;

    /**
     * message 消息
     */
    public string $message = '';
    
    /**
     * data 数据
     */
    public array $data = [];

    /**
     * 成功
     */
    #[Override] public function ok(): array {
        // 初始化返回数据
        $result = [];
        
        // status
        $result[ 'status' ] = $this->status === null?? 1;

        // message
        if( $this->message ) $result[ 'message' ] = $this->message;

        // data
        if( $this->data ) $result[ 'data' ] = $this->data;

        // 返回
        return $result;
    }

    /**
     * 失败
     */
    #[Override] public function fail(): array {
        // 初始化返回数据
        $result = [];
        
        // status
        $result[ 'status' ] = $this->status === null?? 0;

        // message
        if( $this->message ) $result[ 'message' ] = $this->message;

        // data
        if( $this->data ) $result[ 'data' ] = $this->data;

        // 返回
        return $result;
    }
}