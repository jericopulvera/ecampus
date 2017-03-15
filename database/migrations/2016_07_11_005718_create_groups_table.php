<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('term_id')->unsigned();
            $table->string('professor');
            $table->string('subject');
            $table->string('section');
            $table->string('room');
            $table->string('dow');
            $table->string('start');
            $table->string('end');
            $table->string('slug')->unique();
            $table->nullableTimestamps();

            $table->foreign('term_id')->references('id')->on('school_terms')->onDelete('cascade');
        });

        Schema::create('group_post', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->text('body');
            $table->nullableTimestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });

        Schema::create('group_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('group_post_id')->unsigned();
            $table->text('body');
            $table->nullableTimestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_post_id')->references('id')->on('group_post')->onDelete('cascade');
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->string('role')->default('Student');
            $table->boolean('status');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_post');
        Schema::dropIfExists('group_comment');
        Schema::dropIfExists('group_user');
    }
}
