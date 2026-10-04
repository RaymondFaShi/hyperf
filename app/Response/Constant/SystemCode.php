<?php
declare( strict_types = 1 );
namespace App\Response\Constant;

/**
 * 系统级代码
 */
final class SystemCode {
    
    /** success */
    public const SUCCESS = 'SYS10000';

    /** ducoment not found */
    public const DOCUMENT_NOT_FOUND = 'SYS10001';

    /** 500 error */
    public const INTERNAL_SERVER_ERROR = 'SYS10002';
    
    /** 错误的数据 */
    public const INVALID_DATA = 'SYS10003';

    /** 权限不足 */
    public const PERMISSION_DENIED = 'SYS10004';

    /** csrfToken不匹配 */
    public const CSRFTOKEN_MISMATCH = 'SYS10005';
}