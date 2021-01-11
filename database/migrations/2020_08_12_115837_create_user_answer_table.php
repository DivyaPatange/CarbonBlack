<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('take_test_id');
            $table->foreign('take_test_id')->references('id')->on('take_test');
            $table->unsignedInteger('test_id');
            $table->foreign('test_id')->references('id')->on('test');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('question_id');
            $table->foreign('question_id')->references('id')->on('question');
            $table->string('answer_option');
            $table->string('mark');
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
        Schema::dropIfExists('user_answer');
    }
}
