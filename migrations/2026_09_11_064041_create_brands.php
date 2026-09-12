<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        /** 品牌 */
        Schema::create( 'brands', function ( Blueprint $table ) {
            $table->mediumIncrements( 'id' )->comment( '品牌id' );
            $table->string( 'name', 60 )->index( 'name' )->comment( '品牌名称' );
            $table->string( 'flug', 60 )->unique( 'flug' )->comment( '品牌标识' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('brands');
    }
};
