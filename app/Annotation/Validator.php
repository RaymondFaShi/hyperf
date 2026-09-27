<?php
declare( strict_types = 1 );
namespace App\Annotation;

use App\Validator\ValidatorInterface;
use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;

#[Attribute( Attribute::TARGET_CLASS )]
class Validator extends AbstractAnnotation {

    /** 验证器 */
    public readonly ValidatorInterface $validator;

    public function __construct( string $validatorClassName ) {
        $this->validator = new $validatorClassName;
    }
}