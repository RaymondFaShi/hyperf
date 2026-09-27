<?php
declare( strict_types = 1 );
namespace App\Validator;

/**
 * 基础验证器
 */
abstract class BaseValidator implements ValidatorInterface {
    
    /** 验证规则 */
    abstract public function rules( array $allData ): array;

    /** 验证信息 */
    abstract public function messages(): array;

    /** 验证场景 */
    abstract public function scene(): array;

    /** 是否存在场景 */
    public function hasScene( string $name ) {
        return isset( $this->scene()[ $name ] );
    }

    /** 获取场景下验证规则 */
    public function getSceneRule( string $name, array $allData ): array {
        // 如果场景存在
        if( $this->hasScene( $name ) ) {
            // 获取场景
            $scene = $this->scene()[ $name ];

            // 获取验证规则
            $rules = $this->rules( $allData );

            // 规律规则并返回
            return array_filter( $rules, function ( $key ) use ( $scene ) {
                return in_array( $key, $scene )? true: false;
            }, ARRAY_FILTER_USE_KEY );
        }

        return [];
    }
}