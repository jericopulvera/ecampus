<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start');
            $table->date('end');
            $table->string('year');
            $table->enum('semester', ['1st','2nd','3rd']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_terms');
    }
}
