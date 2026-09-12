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
            $table->string( 'name', 120 )->comment( '商品名称' )->index( 'name' );
            

            $table->timestamp( 'updated_at' )->comment( '更新时间' );
            $table->timestamp( 'created_at' )->nullable()->comment( '创建时间' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'products' );
    }
};