<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        /** 角色 */
        Schema::create( 'roles', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->smallIncrements( 'id' )->comment( '角色id' );
            $table->string( 'code', 50 )->unique( 'code' )->comment( '角色标识' );
            $table->string( 'name', 20 )->unique()->comment( '角色名' );
        } );

        /* 角色权限表 */
        Schema::create( 'role_permission', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments( 'id' )->comment( '自增ID' );
            $table->unsignedSmallInteger( 'role_id' )->comment( '角色ID' );
            $table->unsignedMediumInteger( 'permission_id' )->comment( '权限ID' );
            $table->index( [ 'role_id', 'permission_id' ] );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'role' );
        Schema::dropIfExists( 'role_permission' );
    }
};
