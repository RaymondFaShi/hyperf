<?php
declare( strict_types = 1 );
namespace App\Response\Interfaces;

/**
 * 响应数据结构
 */
interface ResultInterface {
    /**
     * 成功
     */
    public function ok(): array;

    /**
     * 失败
     */
    public function fail(): array;
}