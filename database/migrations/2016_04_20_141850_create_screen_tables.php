<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScreenTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screens', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamps();
        });

        Schema::create('screengroup_screen', function (Blueprint $table) {
            $table->integer('screen_group_id')->unsigned()->index();
            $table->foreign('screen_group_id')->references('id')->on('screengroups')->onDelete('cascade');
            $table->integer('screen_id')->unsigned()->index();
            $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('screen_id')->nullable();
            $table->foreign('screen_id')
                ->references('id')->on('screens');

            $table->string('name');
            $table->string('originalName');
            $table->string('path');
            $table->string('thumb_path');
            $table->string('sha1');

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
        Schema::drop('screens');
        Schema::drop('screengroup_screen');
        Schema::drop('photos');
    }
}
