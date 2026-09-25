<?php
/**
 * 日期函数
 */
declare( strict_types = 1 );

/**
 * 距离时间
 * @param string $beginTime 开始天数
 * @param string $overTime 结束天数
 * @param int $type 类型 1-年 2-月 3-日
 * @param bool $useFloat 是否使用浮点数
 * @return int
 */
function distanceTime( string $beginTime, string $overTime, int $type = 1, bool $useFloat = false ): int {
    $distance = 0;  // 距离
    
    // 开始结束时间
    $beginDate = new DateTime( $beginTime );
    $overDate = new DateTime( $overTime );
    
    // 求差
    $diffDate = $beginDate->diff( $overDate );
    if( $diffDate->invert == 0 ) {
        switch( $type ) {
            case 1: 
                $distance = $diffDate->y;
                $lastYear = round( ( $diffDate->days - ( $diffDate->y * 365 ) ) / 365, 2 );
                if( $useFloat ) $distance += $lastYear;
                break;
            case 2: 
                $distance = $diffDate->m;
                $lastMonth = round( ( $diffDate->days - ( $diffDate->m * 30 ) ) / 30, 2 );
                if( $useFloat ) $distance += $lastMonth;
                break;
            case 3: 
                $distance = $diffDate->days; 
                $lastDay = round( $diffDate->h / 24, 2 );
                if( $useFloat ) $distance += $lastDay;
                break;
        }
    }
    
    return $distance;
}

/**
 * 格式化日期
 * @param int|string $time 时间
 * @param string $pattern 日期格式
 */
function formatDate( $time, $pattern = 'Y-m-d' ) {
    $date = $time? date( $pattern, strtotime( $time )?? $time ): '';
    return $date?? '';
}