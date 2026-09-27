<?php
declare( strict_types = 1 );
namespace App\Annotation\Collector;

use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Di\Annotation\AnnotationInterface;
use Hyperf\Di\MetadataCollector;

class ValidatorCollector extends MetadataCollector {


    public function collectClass( string $className ): void {
        AnnotationCollector::collectClass( $className, self::class, $this );
    }

    public function collectClassConstant( string $className, ?string $target ):void {}

    public function collectMethod(string $className, ?string $target): void {}

    public function collectProperty(string $className, ?string $target): void {}
}