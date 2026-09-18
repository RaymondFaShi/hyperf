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
     */
    public function success(
        int|string $code,
        ?ResultInterface $result,
    ): MessageResponseInterface;

    /**
     * 失败
     */
    public function error(
        int|string $code,
        ?ResultInterface $result = null,
    ): MessageResponseInterface;

}