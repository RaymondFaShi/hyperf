<?php
declare( strict_types = 1 );
namespace App\Response\Interfaces;

/**
 * 响应数据结构
 */
interface ResultStruct {
    /**
     * 成功
     */
    public static function ok();

    /**
     * 失败
     */
    public static function fail();
}