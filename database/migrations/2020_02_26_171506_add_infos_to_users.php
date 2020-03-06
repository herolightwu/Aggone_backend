<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfosToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('group_id')->default(1);
            $table->integer('is_active')->default(1);
            $table->string('photo_url')->default("");
            $table->integer('sport_id')->default(500);
            $table->string('city')->default("");
            $table->string('category')->default("");
            $table->string('position')->default("");
            $table->string('country')->default("");
            $table->integer('gender_id')->default(0);
            $table->string('club')->default("");
            $table->integer('age')->default(0);
            $table->integer('height')->default(170);
            $table->integer('weight')->default(70);
            $table->integer('year')->default(1970);
            $table->integer('month')->default(1);
            $table->integer('day')->default(1);
            $table->string('contract')->default("");
            $table->string('web_url')->default("www.aggone.com");
            $table->text('desc_str')->nullable();
            $table->integer('available_club')->default(0);
            $table->string('push_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role_id', 'is_active', 'photo_url', 'sport', 'city', 'category', 'position', 'club', 'age', 'height', 'weight', 'year', 'month',
            'day', 'contract']);
        });
    }
}
