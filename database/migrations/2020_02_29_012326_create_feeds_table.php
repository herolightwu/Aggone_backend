<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type')->default(0); //normal-0, youtube-1
            $table->integer('user_id');
            $table->string('title')->nullable();
            $table->string('video_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->integer('sport_id')->default(1000);
            $table->integer('view_count')->default(0);
            $table->bigInteger('timestamp')->default(0);
            $table->integer('shared')->default(0);
            $table->text('articles')->nullable();
            $table->text('tagged')->nullable();
            $table->integer('mode')->default(0);
            $table->text('desc_str')->nullable();
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
        Schema::dropIfExists('feeds');
    }
}
