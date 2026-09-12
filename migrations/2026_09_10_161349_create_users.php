<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        /** 用户 */
        Schema::create( 'users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->mediumIncrements( 'id' )->comment( '用户id' );
            $table->string( 'username', 50 )->unique()->comment( '用户名' );
            $table->string( 'email', 255 )->unique()->comment( '邮箱' );
            $table->string( 'telephone', 30 )->comment( '联系电话' );
            $table->string( 'password', 32 )->comment('密码');
            $table->string( 'salt', 4 )->comment( '扰乱码' );
            $table->unsignedTinyInteger( 'status' )->default( 1 )->comment( '状态:0-冻结 1-正常 2-锁定' );
        } );

        /** 用户数据表 */
        Schema::create( 'user_data', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->mediumIncrements( 'id' )->comment( '自增id' );
            $table->unsignedMediumInteger( 'user_id' )->unique()->comment( '用户id' );
            $table->string( 'realname', 20 )->comment( '真实姓名' );
            $table->timestamp( 'last_login_at' )->comment( '最后登录时间' );
            $table->timestamp( 'created_at' )->nullable()->comment( '创建时间' );
        } );

        /** 用户角色表 */
        Schema::create( 'user_role', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->mediumIncrements( 'id' )->comment( '自增id' );
            $table->unsignedMediumInteger( 'user_id' )->comment( '用户id' );
            $table->unsignedSmallInteger( 'role_id' )->comment( '角色id' );
            $table->unique( [ 'role_id', 'user_id' ] );
        } );

        /* 用户额外权限表 */
        Schema::create( 'user_permission', function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->mediumIncrements( 'id' )->comment( '自增id' );
            $table->unsignedMediumInteger( 'user_id')->comment( '用户id' );
            $table->unsignedMediumInteger( 'permission_id' )->comment( '权限id' );
            $table->unique( [ 'user_id', 'permission_id' ] );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'users' );
        Schema::dropIfExists( 'user_data' );
        Schema::dropIfExists( 'user_role' );
        Schema::dropIfExists( 'user_permission' );
    }
};