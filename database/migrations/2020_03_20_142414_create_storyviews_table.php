<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storyviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('story_id');
            $table->integer('user_id');
            $table->integer('view_count')->default(1);
            $table->bigInteger('timestamp')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storyviews');
    }
}
