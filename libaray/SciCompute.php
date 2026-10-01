<?php
/**
 * SciCompute 科学计算类
 * @Version 1.0.0
 */
declare( strict_types = 1 );
namespace Libaray;

use NXP\MathExecutor;

/**
 * 科学计算类
 */
final class SciCompute {

    /** 计算精度 */
    private const CALC_PRECISION = 20;

    /**
     * 计算入口
     * @param string $expression 表达式
     * @param array $variables 变量
     * @param int $precision 返回精度
     */
    public static function calc( string $expression, array $variables, int $precision = 16 ): string {
        // 初始化执行器
        $executor = new MathExecutor();

        // 使用bcmatch,并且设置精度
        $executor->useBCMath( self::CALC_PRECISION );

        // 变量循环赋值
        foreach( $variables as $name => $value ) $executor->setVar( $name, $value );

        // 获取执行结果
        $result = $executor->execute( $expression );

        // 返回
        return bcround( ( string ) $result, $precision );
    }
}