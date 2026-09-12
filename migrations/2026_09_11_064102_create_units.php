<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        /** 单位 */
        Schema::create('units', function (Blueprint $table) {
            $table->smallIncrements( 'id' )->comment( '单位id' );
            $table->string( 'name_cn', 10 )->unique( 'name_cn' )->comment( '单位名(中文)' );
            $table->string( 'name_en', 10 )->unique( 'name_en' )->comment( '单位名(英文)' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'units' );
    }
};
