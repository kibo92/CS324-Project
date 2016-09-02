<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
			$table->string('title');
			$table->string('text');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->dateTime('created_at');
        });
		
		Schema::create('comments', function (Blueprint $table){
			$table->increments('id');
			$table->string('text');
			$table->integer('blog_id')->unsigned();
			$table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->dateTime('created_at');
			
			
		});
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blog');
    }
}
