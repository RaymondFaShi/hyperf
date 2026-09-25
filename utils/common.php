<?php
/**
 * 公共函数
 */
declare( strict_types = 1 );

use function Hyperf\Support\env;

/**
 * 打印日志(开发模式下)
 * @param mixed $content 日志数据
 * @param int $printMode [ 1-print_r 2-var_dump 3-var_export ]
 */
function devLog( mixed $content, int $printMode = 1 ) {
    // 开发模式下
    if( env( 'APP_ENV' ) !== 'dev' ) return ;

    // 打印类型
    switch ( $printMode ) {
        case 1: print_r( $content ); break;
        case 2: var_dump( $content ); break;
        case 3: var_export( $content ); break;
    }
}

/**
 * 安全随机数
 * @param $length 生成字符串长度
 * @param int $type 生成类型 [ 0-默认 1-数字 2-数字+小写字母+大写字母 ]
 * @param bool $repeat 是否重复[ false ]
 */
function randStr( int $length, $type = 0, bool $repeat = false ): bool|string {
    // 源字符
    $lower = 'abcdefghijklmnopqrstuvwxyz';   // 小写字母
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';   // 大写字母
    $number = '0123456789';                  // 数字

    // 种子
    $seed = match( $type ) {
        1 => $number,
        2 => $number. $lower. $upper,
        default => $number. $lower,
    };
    $seedLength = strlen( $seed );

    // 如果不能重复，字符不能超过种子数
    if( !$repeat && $length > $seedLength ) return false;

    // 生成字符串
    $string = [];
    while ( strlen( $string ) < $length ) {
        // 随机字符
        $char = $seed[ random_int( 0, $seedLength - 1 ) ];

        // 去重
        if ( !$repeat && str_contains( $string, $char ) ) continue;

        // 追加
        $string .= $char;
    }

    return $string;
}

/**
 * object转成array
 * @param object $obj object
 */
function objectToArray( object $obj ): bool|array {
    return json_decode(
        json_encode( $obj, JSON_UNESCAPED_UNICODE ),
        true
    );
}

/**
 * 数组指定位置插入数组
 * @param array $originArr 原始数组
 * @param string $afterKeyName 在之后插入的键名
 * @param array $insertArr 需要插入的数组
 */
function arrayInsertAfter( array $originArr, string $afterKeyName, array $insertArr ): array {
    // 返回数据
    $result = [];

    foreach( $originArr as $originKey => $originValue ) {
        $result[ $originKey ] = $originValue;
        
        if( $originKey === $afterKeyName ) {
            foreach( $insertArr as $insertKey => $insertValue ) {
                $result[ $insertKey ] = $insertValue;
            }
        }
    }

    return $result;
}