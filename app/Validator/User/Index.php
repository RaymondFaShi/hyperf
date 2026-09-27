<?php
declare( strict_types = 1 );
namespace App\Validator\User;

use App\Validator\ValidatorInterface;

/**
 * 基础验证器
 */
class Index implements ValidatorInterface {
    
    // 验证规则
    public function rules( array $allData ): array {
        return [];
    }

    // 验证信息
    public function messages(): array {
        return [];
    }

    // 验证场景
    public function scene(): array {
        return [];
    }
}