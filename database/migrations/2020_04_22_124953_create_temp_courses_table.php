<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('users');
            $table->string('title');
            $table->string('img');
            $table->string('path');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_courses');
    }
}
