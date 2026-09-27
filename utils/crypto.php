<?php
/**
 * 加密函数
 */
declare( strict_types = 1 );

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
 * 生成uid
 * @param int $length uid长度
 */
function generateUID( int $length = 16 ): string {
    return bin2hex( random_bytes( $length ) );
}