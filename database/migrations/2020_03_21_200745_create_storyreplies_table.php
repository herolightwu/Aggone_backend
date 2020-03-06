<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryrepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storyreplies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('story_id');
            $table->integer('user_id');
            $table->integer('reply_type')->default(0);//1-chat, 2-image
            $table->text('content')->nullable();
            $table->bigInteger('timestamp');
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
        Schema::dropIfExists('storyreplies');
    }
}
