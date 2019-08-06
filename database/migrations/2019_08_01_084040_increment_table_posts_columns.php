<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncrementTablePostsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->text('image')->nullable();
            $table->string('friendly_url')->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->integer('highlight')->nullable()->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('friendly_url');
            $table->dropColumn('image');
            $table->dropColumn('status');
        });
    }
}
