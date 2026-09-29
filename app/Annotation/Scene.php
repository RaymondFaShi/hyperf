<?php
declare( strict_types = 1 );
namespace App\Annotation;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;

#[Attribute( Attribute::TARGET_METHOD )]
class Scene extends AbstractAnnotation {
    /**
     * construct
     * @param string $scene 验证器场景
     */
    public function __construct( 
        public string $scene,
    ) {

    }
}