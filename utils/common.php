<?php
/**
 * 公共函数
 */
declare( strict_types = 1 );

use function Hyperf\Support\env;

/**
 * 打印日志(开发模式下)
 * @param mixed $content 日志数据
 * @param int $printMode [ 1-print_r|var_dump 2-var_dump 3-var_export ]
 */
function devLog( mixed $content, int $printMode = 1 ) {
    // 开发模式下
    if( env( 'APP_ENV' ) !== 'dev' ) return ;

    // 打印类型
    switch ( $printMode ) {
        case 1: $content? print_r( $content ): var_dump( $content ); break;
        case 2: var_dump( $content ); break;
        case 3: var_export( $content ); break;
    }
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