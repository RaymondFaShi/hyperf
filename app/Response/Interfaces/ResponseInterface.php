<?php
declare( strict_types = 1 );
namespace App\Response\Interfaces;

use Psr\Http\Message\ResponseInterface as MessageResponseInterface;

/**
 * 响应数据结构
 */
interface ResponseInterface {
    /**
     * 成功
     * @param int|string $code 系统码
     * @param ResultInterface $result 业务数据
     * @param array $appendData 追加数据
     */
    public function success(
        int|string $code,
        ?ResultInterface $result = null,
        ?array $appendData = null,
    ): MessageResponseInterface;

    /**
     * 失败
     * @param int|string $code 系统码
     * @param ResultInterface $result 业务数据
     * @param array $appendData 追加数据
     */
    public function error(
        int|string $code,
        ?ResultInterface $result = null,
        ?array $appendData = null,
    ): MessageResponseInterface;

}