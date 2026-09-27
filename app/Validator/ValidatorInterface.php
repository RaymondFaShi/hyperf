<?php
declare( strict_types = 1 );
namespace App\Validator;

/**
 * 验证器接口
 */
interface ValidatorInterface {
    
    /** 验证规则 */
    public function rules( array $requestData ): array;

    /** 验证信息 */
    public function messages(): array;

    /** 验证场景 */
    public function scene(): array;
}