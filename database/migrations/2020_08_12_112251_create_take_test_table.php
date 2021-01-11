<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTakeTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('take_test', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('test_id');
            $table->foreign('test_id')->references('id')->on('test');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');
            $table->boolean('status')->default(0);
            $table->string('result')->nullable();
            $table->boolean('is_verified')->default(0);
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
        Schema::dropIfExists('take_test');
    }
}
