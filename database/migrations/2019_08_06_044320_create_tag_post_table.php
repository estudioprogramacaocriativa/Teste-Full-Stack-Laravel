<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagPostTable extends Migration
{
    public function up()
    {
        Schema::create('tag_post', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tag_id');
            $table->unsignedInteger('post_id');

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('restrict');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tag_post');
    }
}
