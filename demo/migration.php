<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        /** 通用 */
        Schema::create( 'demo', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->tinyIncrements( 'id' )->comment( 'id' );
            $table->smallIncrements( 'id' )->comment( 'id' );
            $table->mediumIncrements( 'id' )->comment( 'id' );
            $table->increments( 'id' )->comment( 'id' );
            
            $table->unsignedTinyInteger( 'parent_id' )->index()->comment( '父id' );
            $table->unsignedSmallInteger( 'parent_id' )->index()->comment( '父id' );
            $table->unsignedMediumInteger( 'parent_id' )->index()->comment( '父id' );
            $table->unsignedInteger( 'parent_id' )->index()->comment( '父id' );

            $table->unsignedTinyInteger( 'status' )->default( 1 )->comment( '状态:0-禁止 1-正常' );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'demo' );
    }
};
