<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        /** 商品 */
        Schema::create( 'products', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments( 'id' )->comment( '商品id' );
            $table->unsignedTinyInteger( 'category_id' )->index( 'category_id' )->comment( '分类id' );
            $table->string( 'name', 120 )->index( 'name' )->comment( '商品名称' );
            $table->unsignedSmallInteger( 'unit_id' )->default( 0 )->index( 'unit_id' )->comment( '单位id' );
            $table->unsignedMediumInteger( 'brand_id' )->default( 0 )->index( 'brand_id' )->comment( '品牌id' );
            $table->string( 'spu', 20 )->unique( 'spu' )->comment( '商品spu' );

            $table->tinyInteger( 'enable' )->default( 1 )->comment( '产品状态：0为禁用，1为启用' );

            $table->timestamp( 'updated_at' )->nullable()->comment( '更新时间' );
            $table->timestamp( 'created_at' )->comment( '创建时间' );
        } );

        /** 商品属性 */
        Schema::create( 'product_attributes', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments( 'id' )->comment( '属性id' );
            $table->string( 'name', 20 )->unique( 'sku' )->comment( '属性名' );
        } );


        /** 商品变体 */
        Schema::create( 'product_variants', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->bigIncrements( 'id' )->comment( '商品id' );
            $table->string( 'name', 120 )->index( 'name' )->comment( '变体名称' );
            $table->string( 'sku', 20 )->unique( 'sku' )->comment( '变体sku' );
            $table->timestamp( 'deleted_at' )->nullable()->comment( '删除时间' );
        } );

        /** 商品变体属性 */
        Schema::create( 'product_variant_attributes', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->bigIncrements( 'id' )->comment( '属性id' );
            $table->unsignedBigInteger( 'variant_id' )->index( 'variant_id' )->comment( '属性id' );
            $table->string( 'name', 20 )->unique( 'sku' )->comment( '属性名' );
        } );

        /** 商品变体条码 */
        Schema::create( 'product_variant_barcodes', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->bigIncrements( 'id' )->comment( '条码id' );
            $table->unsignedBigInteger( 'variant_id' )->index( 'variant_id' )->comment( '属性id' );
            $table->string( 'barcode', 50 )->unique( 'barcode' )->comment( '条码' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'products' );
    }
};