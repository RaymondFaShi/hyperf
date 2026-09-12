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
        Schema::create( 'sites', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->smallIncrements( 'id' )->comment( '站点id' );
            $table->string( 'name', 30 )->unique( 'name' )->comment( '站点名称' );
            $table->string( 'domain', 255 )->unique( 'domain' )->comment( '站点域名' );
            $table->unsignedTinyInteger( 'status' )->default( 1 )->comment( '状态:0-禁止 1-正常' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'sites' );
    }
};
