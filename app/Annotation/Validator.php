<?php
declare( strict_types = 1 );
namespace App\Annotation;

use App\Validator\ValidatorInterface;
use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;

#[Attribute( Attribute::TARGET_CLASS )]
class Validator extends AbstractAnnotation {
    /**
     * construct
     * @param string $validatorClassName 验证器类名
     */
    public function __construct( 
        public string $validatorClassName,
    ) {

    }
}