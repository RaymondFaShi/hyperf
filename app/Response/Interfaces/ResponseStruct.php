<?php
declare( strict_types = 1 );
namespace App\Response\Interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * 响应数据结构
 */
interface ResponseStruct {
    /**
     * 成功
     */
    public function success(
        int|string $code,
        ?ResultStruct $result,
    ): ResponseInterface;

    /**
     * 失败
     */
    public function error(
        int|string $code,
    ): ResponseInterface;

}