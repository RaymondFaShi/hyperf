<?php
declare( strict_types = 1 );
namespace App\Validator\User;

use App\Validator\BaseValidator;

/**
 * 基础验证器
 */
class Index extends BaseValidator {
    
    // 验证规则
    public function rules( array $allData ): array {
        return [
            'page_no' => [ 'integer' ],
            'page_size' => [ 'integer' ],
        ];
    }

    // 验证信息
    public function messages(): array {
        return [
            'page_no.integer' => '页码必须是数字',
            'page_size.integer' => '页面尺寸必须是数字'
        ];
    }

    // 验证场景
    public function scene(): array {
        return [
            'index' => [ 'page_no', 'page_size' ]
        ];
    }
}