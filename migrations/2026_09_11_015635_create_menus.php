<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        /** 菜单 */
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->mediumIncrements( 'id' )->comment( '菜单id' );
            $table->unsignedMediumInteger( 'parent_id' )->index( 'parent_id' )->default( 0 )->comment( '父级菜单ID' );
            $table->string( 'name', 30 )->comment( '菜单名，对应前端的语言包' );
            $table->string( 'router', 255 )->comment( '前端路由' );
            $table->unsignedMediumInteger( 'sort' )->default( 0 )->comment( '排序' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'menus' );
    }
};
