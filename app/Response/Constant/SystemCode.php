<?php
declare( strict_types = 1 );
namespace App\Response\Constant;

/**
 * 系统级代码
 */
final class SystemCode {
    
    /** ducoment not found */
    public const DOCUMENT_NOT_FOUND = 'E10000';

    /** 500 error */
    public const INTERNAL_SERVER_ERROR = 'E10001';
    
    /** 错误的数据 */
    public const INVALID_DATA = 'E10002';

    /** 权限不足 */
    public const PERMISSION_DENIED = 'E10003';
    
}