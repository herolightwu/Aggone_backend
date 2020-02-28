<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('position')->nullable();
            $table->string('sport_id');
            $table->string('club');
            $table->string('logo')->nullable();
            $table->string('location')->nullable();
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->integer('tyear');
            $table->integer('tmonth');
            $table->integer('tday');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('careers');
    }
}
